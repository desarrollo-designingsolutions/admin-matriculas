<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseBook\CourseBookStoreRequest;
use App\Http\Resources\CourseBook\CourseBookFormResource;
use App\Http\Resources\CourseBook\CourseBookListResource;
use App\Repositories\CourseBookRepository;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseBookController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        protected CourseBookRepository $courseBookRepository
    ) {}

    public function list(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->courseBookRepository->paginate($request->all());
            $tableData = CourseBookListResource::collection($data);

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

    public function store(CourseBookStoreRequest $request)
    {
        return $this->runTransaction(function () use ($request) {
            $post = $request->except(['start_date']);
            $data = $this->courseBookRepository->store($post);

            return [
                'code' => 200,
                'message' => 'Datos agregados correctamente',
            ];
        });
    }

    public function edit($id)
    {
        return $this->execute(function () use ($id) {
            $data = $this->courseBookRepository->find($id);
            $form = new CourseBookFormResource($data);

            return [
                'code' => 200,
                'form' => $form,
            ];
        });
    }

    public function update(CourseBookStoreRequest $request, $id)
    {
        return $this->runTransaction(function () use ($request, $id) {
            $post = $request->except(['start_date']);
            $data = $this->courseBookRepository->store($post, $id);

            return [
                'code' => 200,
                'message' => 'Datos modificados correctamente',
            ];
        });
    }

    public function delete($id)
    {
        return $this->runTransaction(function () use ($id) {
            $data = $this->courseBookRepository->find($id);
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
