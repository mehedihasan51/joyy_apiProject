<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'password'     => $this->password,
            'country'      => $this->country
        ];
    }
}
