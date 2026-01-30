<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Resources\Course\CourseFormResource;
use App\Http\Resources\Course\CourseListResource;
use App\Repositories\CourseRepository;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        protected CourseRepository $courseRepository
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
            $post = $request->except([]);
            $data = $this->courseRepository->store($post);

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
            $post = $request->except(['start_date']);
            $data = $this->courseRepository->store($post, $id);

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
