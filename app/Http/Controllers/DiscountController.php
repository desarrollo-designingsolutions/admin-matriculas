<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discount\DiscountStoreRequest;
use App\Http\Resources\Discount\DiscountFormResource;
use App\Http\Resources\Discount\DiscountListResource;
use App\Repositories\DiscountRepository;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        protected DiscountRepository $discountRepository
    ) {}

    public function list(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->discountRepository->paginate($request->all());
            $tableData = DiscountListResource::collection($data);

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
            return [
                'code' => 200,
                'form' => [],
            ];
        });
    }

    public function store(DiscountStoreRequest $request)
    {
        return $this->runTransaction(function () use ($request) {
            $post = $request->except([]);
            $data = $this->discountRepository->store($post);

            return [
                'code' => 200,
                'message' => 'Datos agregados correctamente',
            ];
        });
    }

    public function edit($id)
    {
        return $this->execute(function () use ($id) {
            $data = $this->discountRepository->find($id);
            $form = new DiscountFormResource($data);

            return [
                'code' => 200,
                'form' => $form,
            ];
        });
    }

    public function update(DiscountStoreRequest $request, $id)
    {
        return $this->runTransaction(function () use ($request, $id) {
            $post = $request->except([]);
            $data = $this->discountRepository->store($post, $id);

            return [
                'code' => 200,
                'message' => 'Datos modificados correctamente',
            ];
        });
    }

    public function delete($id)
    {
        return $this->runTransaction(function () use ($id) {
            $data = $this->discountRepository->find($id);
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
