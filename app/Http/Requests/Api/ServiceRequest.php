<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class ServiceRequest extends FormRequest
{

    private Helper $helper;

    public function __construct(Helper $helper) {
        $this->helper = $helper;
        parent::__construct();
    }

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
            'title'            => 'required|string|max:50',
            'image'            => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:10240',
            'description'      => 'required|string',
            'sub_description'  => 'required|string',
            'category_id'      => 'required|exists:categories,id'
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
