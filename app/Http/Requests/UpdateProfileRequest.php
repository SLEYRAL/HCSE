<?php

namespace App\Http\Requests;

use App\Enum\StatusProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->is_admin) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lastname' => 'string',
            'firstname' => 'string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status' => [Rule::enum(StatusProfile::class)]
        ];
    }
}
