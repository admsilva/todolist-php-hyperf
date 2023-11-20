<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'start_at' => 'required|date_format:Y-m-d H:i:s|before:end_at',
            'end_at' => 'required|date_format:Y-m-d H:i:s|after:start_at',
            'priority' => 'required',
        ];
    }
}
