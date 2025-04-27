<?php

namespace App\Http\Requests\Api\Auth;

use App\Helpers\Helper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest {
    private Helper $helper;

    public function __construct(Helper $helper) {
        $this->helper = $helper;
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array {
        return [
            'name' => 'required|string|alpha|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'country'    => 'required|string|alpha|max:255',
            // 'password'   => [
            //     'required',
            //     'string',
            //     'min:8',
            //     'confirmed',
            //     'regex:/[a-z]/',
            //     'regex:/[A-Z]/',
            //     'regex:/[0-9]/',
            //     'regex:/[@$!%*?&#]/'
            // ],
            'password'   => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void {
        $response = $this->helper->jsonResponse(false, 'Validation failed', 422, ['errors' => $validator->errors()], 422);
        throw new ValidationException($validator, $response);
    }
}
