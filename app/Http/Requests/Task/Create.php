<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TaskRule;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required|numeric',
            'task_title' => 'required|string|max:255',
            'tast_description' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => ['required', new TaskRule],
        ];
    }
}
