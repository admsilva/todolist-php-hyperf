<?php

declare(strict_types=1);

namespace App\Request;

use App\Constants\Profile;
use Hyperf\Validation\Request\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'profile' => 'required|in:' . implode(',', Profile::values()),
            'password' => 'required',
        ];
    }
}
