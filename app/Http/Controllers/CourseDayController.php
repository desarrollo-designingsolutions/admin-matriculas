<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseDay\CourseDayStoreRequest;
use App\Http\Resources\CourseDay\CourseDayFormResource;
use App\Http\Resources\CourseDay\CourseDayListResource;
use App\Repositories\CourseDayRepository;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseDayController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        protected CourseDayRepository $courseDayRepository
    ) {}

    public function list(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->courseDayRepository->paginate($request->all());
            $tableData = CourseDayListResource::collection($data);

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

    public function store(CourseDayStoreRequest $request)
    {
        return $this->runTransaction(function () use ($request) {
            $post = $request->except(['start_date']);
            $data = $this->courseDayRepository->store($post);

            return [
                'code' => 200,
                'message' => 'Datos agregados correctamente',
            ];
        });
    }

    public function edit($id)
    {
        return $this->execute(function () use ($id) {
            $data = $this->courseDayRepository->find($id);
            $form = new CourseDayFormResource($data);

            return [
                'code' => 200,
                'form' => $form,
            ];
        });
    }

    public function update(CourseDayStoreRequest $request, $id)
    {
        return $this->runTransaction(function () use ($request, $id) {
            $post = $request->except(['start_date']);
            $data = $this->courseDayRepository->store($post, $id);

            return [
                'code' => 200,
                'message' => 'Datos modificados correctamente',
            ];
        });
    }

    public function delete($id)
    {
        return $this->runTransaction(function () use ($id) {
            $data = $this->courseDayRepository->find($id);
            if ($data) {
                $data->delete();
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
}
