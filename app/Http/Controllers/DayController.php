<?php

namespace App\Http\Controllers;

use App\Http\Requests\Day\DayStoreRequest;
use App\Http\Resources\Day\DayFormResource;
use App\Http\Resources\Day\DayListResource;
use App\Repositories\DayRepository;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DayController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        protected DayRepository $dayRepository
    ) {}

    public function list(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->dayRepository->paginate($request->all());
            $tableData = DayListResource::collection($data);

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

    public function store(DayStoreRequest $request)
    {
        return $this->runTransaction(function () use ($request) {
            $post = $request->except(['start_date']);
            $data = $this->dayRepository->store($post);

            return [
                'code' => 200,
                'message' => 'Datos agregados correctamente',
            ];
        });
    }

    public function edit($id)
    {
        return $this->execute(function () use ($id) {
            $data = $this->dayRepository->find($id);
            $form = new DayFormResource($data);

            return [
                'code' => 200,
                'form' => $form,
            ];
        });
    }

    public function update(DayStoreRequest $request, $id)
    {
        return $this->runTransaction(function () use ($request, $id) {
            $post = $request->except(['start_date']);
            $data = $this->dayRepository->store($post, $id);

            return [
                'code' => 200,
                'message' => 'Datos modificados correctamente',
            ];
        });
    }

    public function delete($id)
    {
        return $this->runTransaction(function () use ($id) {
            $data = $this->dayRepository->find($id);
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
