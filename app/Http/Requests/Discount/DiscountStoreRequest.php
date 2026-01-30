<?php

namespace App\Http\Requests\Discount;

use App\Helpers\Constants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiscountStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'start_date' => 'required',
            'finish_date' => 'required',
            'discount' => 'required',
            'payback' => 'required',
            'link' => 'required',
            'link_book' => 'required',
            'day_course_id' => 'required',
        ];


        return $rules;
    }

    public function messages(): array
    {
        return [
            'start_date.required' => 'El campo es obligatorio',
            'finish_date.required' => 'El campo es obligatorio',
            'discount.required' => 'El campo es obligatorio',
            'payback.required' => 'El campo es obligatorio',
            'link.required' => 'El campo es obligatorio',
            'link_book.required' => 'El campo es obligatorio',
            'day_course_id.required' => 'El campo es obligatorio',
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->has('day_course_id')) {
            $merge['day_course_id'] = getValueSelectInfinite($this->day_course_id);
        }

        $this->merge($merge);
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'code' => 422,
            'message' => Constants::ERROR_MESSAGE_VALIDATION_BACK,
            'errors' => $validator->errors(),
        ], 422));
    }
}
