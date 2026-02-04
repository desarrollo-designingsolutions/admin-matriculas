<?php

namespace App\Http\Requests\Course;

use App\Helpers\Constants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'time' => 'required',
            'modalidad' => 'required',
            'course_init' => 'required',
            'price' => 'required',
            'orden' => 'required',
            'periodo' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'finish_date' => 'required',
            'discount' => 'required',
            'link' => 'required',
            'link_book' => 'required',
            'level_id' => 'required',
            'period_id' => 'required',
            'book_id' => 'sometimes|nullable',
            'day_id' => 'required',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo es obligatorio',
            'time.required' => 'El campo es obligatorio',
            'modalidad.required' => 'El campo es obligatorio',
            'course_init.required' => 'El campo es obligatorio',
            'price.required' => 'El campo es obligatorio',
            'orden.required' => 'El campo es obligatorio',
            'periodo.required' => 'El campo es obligatorio',
            'status.required' => 'El campo es obligatorio',
            'start_date.required' => 'El campo es obligatorio',
            'finish_date.required' => 'El campo es obligatorio',
            'discount.required' => 'El campo es obligatorio',
            'link.required' => 'El campo es obligatorio',
            'link_book.required' => 'El campo es obligatorio',
            'level_id.required' => 'El campo es obligatorio',
            'period_id.required' => 'El campo es obligatorio',
            'day_id.required' => 'El campo es obligatorio',
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->has('level_id')) {
            $merge['level_id'] = getValueSelectInfinite($this->level_id);
        }
        if ($this->has('period_id')) {
            $merge['period_id'] = getValueSelectInfinite($this->period_id);
            $merge['periodo'] = getValueSelectInfinite($this->period_id, 'title');
        }
        if ($this->has('book_id')) {
            $merge['book_id'] = getValueSelectInfinite($this->book_id);
        }
        if ($this->has('day_id')) {
            $merge['day_id'] = getValueSelectInfinite($this->day_id);
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
