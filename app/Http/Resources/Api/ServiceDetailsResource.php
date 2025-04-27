<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ServiceDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             
                     'title'      => $this->title,
                'description'     => $this->description,  
                'sub_description' => $this->sub_description,
                     'image'      => $this->image_url,
                 'time_ago'        => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
