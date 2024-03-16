<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Request;

use App\Constants\Priority;
use Hyperf\Validation\Request\FormRequest;

class TaskRequest extends FormRequest
{
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
            'priority' => 'required|in:' . implode(',', Priority::values()),
        ];
    }
}
