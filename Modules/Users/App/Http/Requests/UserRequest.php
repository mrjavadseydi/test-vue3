<?php

namespace Modules\Users\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        //get allowed roles from helper function
        $allowed_roles = allowed_roles();
        ///if the request is for updating a user password can be empty
        $is_update = request()->method() === 'PUT';
        $uniq =$is_update ? Rule::unique('users')->ignore($this->id) : 'unique:users';
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required','email',$uniq],
            'mobile' => 'required|string|max:255',
            'role' => ['required', 'string', 'max:255', 'in:'.implode(',',$allowed_roles)],
            'password' => [$is_update?"nullable":"required", "string", "min:8"],
        ];
    }
}
