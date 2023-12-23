<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|unique:quizzes',
            'quiz_date' => 'required|date_format:Y-m-d',
            'name' => 'required|string',
            'quiz_time' => 'nullable|numeric',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.answer' => 'required|string',
            'questions.*.wrong_answer1' => 'required|string',
            'questions.*.wrong_answer2' => 'nullable|string',
            'questions.*.wrong_answer3' => 'nullable|string',
        ];
    }
}
