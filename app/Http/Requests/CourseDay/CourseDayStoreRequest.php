<?php

namespace App\Http\Requests\CourseDay;

use App\Helpers\Constants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseDayStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'time' => 'required',
            'modalidad' => 'required',
            'course_init' => 'required',
            'price' => 'required',
            'orden' => 'required',
            'periodo' => 'required',
            'course_id' => 'required',
            'day_id' => 'required',
            'status' => 'required',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'time.required' => 'El campo es obligatorio',
            'modalidad.required' => 'El campo es obligatorio',
            'course_init.required' => 'El campo es obligatorio',
            'price.required' => 'El campo es obligatorio',
            'orden.required' => 'El campo es obligatorio',
            'periodo.required' => 'El campo es obligatorio',
            'course_id.required' => 'El campo es obligatorio',
            'day_id.required' => 'El campo es obligatorio',
            'status.required' => 'El campo es obligatorio',
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->has('day_id')) {
            $merge['day_id'] = getValueSelectInfinite($this->day_id);
        }
        
        if ($this->has('periodo')) {
            $merge['periodo'] = getValueSelectInfinite($this->periodo, 'title');
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
