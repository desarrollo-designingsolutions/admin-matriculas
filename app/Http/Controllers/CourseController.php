<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Resources\Course\CourseFormResource;
use App\Http\Resources\Course\CourseListResource;
use App\Repositories\CourseRepository;
use App\Repositories\CourseBookRepository;
use App\Repositories\CourseDayRepository;
use App\Repositories\DiscountRepository;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseBook;
use App\Models\CourseDay;
use App\Models\Discount;

class CourseController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        protected CourseRepository $courseRepository,
        protected CourseBookRepository $courseBookRepository,
        protected CourseDayRepository $courseDayRepository,
        protected DiscountRepository $discountRepository,
    ) {}

    public function list(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->courseRepository->paginate($request->all());
            $tableData = CourseListResource::collection($data);

            return [
                'code' => 200,
                'tableData' => $tableData,
                'lastPage' => $data->lastPage(),
                'totalData' => $data->total(),
                'totalPage' => $data->perPage(),
                'currentPage' => $data->currentPage(),
            ];
        });
    }

    public function create()
    {
        return $this->execute(function () {
            $form['start_date'] = Carbon::now()->format('Y-m-d');

            return [
                'code' => 200,
                'form' => $form,
            ];
        });
    }

    public function store(CourseStoreRequest $request)
    {
        return $this->runTransaction(function () use ($request) {
            $course = $this->courseRepository->store([
                'name' => $request->name,
                'level_id' => $request->level_id,
                'period_id' => $request->period_id
            ]);

            if ($request->book_id) {
                $book = $this->courseBookRepository->store([
                    'book_id' => $request->level_id,
                    'course_id' => $course->id
                ]);
            }
            
            $days = $this->courseDayRepository->store([
                'time' => $request->time,
                'modalidad' => $request->modalidad,
                'course_init' => $request->course_init,
                'price' => $request->price,
                'orden' => $request->orden,
                'periodo' => $request->periodo,
                'status' => $request->status,
                'day_id' => $request->day_id,
                'course_id' => $course->id
            ]);

            $discount = $this->discountRepository->store([
                'start_date' => $request->start_date,
                'finish_date' => $request->finish_date,
                'discount' => $request->discount,
                'payback' => 0,
                'link' => $request->link,
                'link_book' => $request->link_book,
                'day_course_id' => $days->id,
            ]);

            return [
                'code' => 200,
                'message' => 'Datos agregados correctamente',
            ];
        });
    }

    public function edit($id)
    {
        return $this->execute(function () use ($id) {
            $data = $this->courseRepository->find($id);
            $form = new CourseFormResource($data);

            return [
                'code' => 200,
                'form' => $form,
            ];
        });
    }

    public function update(CourseStoreRequest $request, $id)
    {
        return $this->runTransaction(function () use ($request, $id) {
            $courseBook = CourseBook::where('course_id', $id)->first();
            $courseDay = CourseDay::where('course_id', $id)->first();
            $discount = Discount::where('day_course_id', $courseDay?->id)->first();

            $course = $this->courseRepository->store([
                'id' => $request->id,
                'name' => $request->name,
                'level_id' => $request->level_id,
                'period_id' => $request->period_id
            ]);

            if ($request->book_id) {
                $book = $this->courseBookRepository->store([
                    'id' => $courseBook->id,
                    'book_id' => $request->level_id,
                    'course_id' => $course->id
                ]);
            }
            
            $days = $this->courseDayRepository->store([
                'id' => $courseDay->id,
                'time' => $request->time,
                'modalidad' => $request->modalidad,
                'course_init' => $request->course_init,
                'price' => $request->price,
                'orden' => $request->orden,
                'periodo' => $request->periodo,
                'status' => $request->status,
                'day_id' => $request->day_id,
                'course_id' => $course->id
            ]);

            $discount = $this->discountRepository->store([
                'id' => $discount->id,
                'start_date' => $request->start_date,
                'finish_date' => $request->finish_date,
                'discount' => $request->discount,
                'payback' => 0,
                'link' => $request->link,
                'link_book' => $request->link_book,
                'day_course_id' => $days->id,
            ]);

            return [
                'code' => 200,
                'message' => 'Datos modificados correctamente',
            ];
        });
    }

    public function delete($id)
    {
        return $this->runTransaction(function () use ($id) {
            $data = $this->courseRepository->find($id);
            if ($data) {
                $data->delete();

                // Borra el libro
                CourseBook::where('course_id', $id)->delete();
                
                // Busca y cambiar el estado de CourseDay
                $courseDay = CourseDay::where('course_id', $id)->first();
                $courseDay->status = "Finalizado";
                $courseDay->save();

                // Elimina el descuento
                Discount::where('day_course_id', $courseDay?->id)->delete();

                // Elimina el CourseDay
                $courseDay->delete();

                $msg = 'Registro eliminado correctamente';
            } else {
                $msg = 'El registro no existe';
            }
            DB::commit();

            return [
                'code' => 200,
                'message' => $msg,
            ];
        }, 200);
    }

    public function changeStatus(Request $request)
    {
        return $this->runTransaction(function () use ($request) {
            $model = CourseDay::where('course_id', $request->id)->first();
            $model->status = $request->value;
            $model->save();

            ($model->status == "Activo") ? $msg = 'Activado' : $msg = 'Finalizado';

            return [
                'code' => 200,
                'message' => 'Curso '.$msg.' con éxito',
            ];
        });
    }
}
