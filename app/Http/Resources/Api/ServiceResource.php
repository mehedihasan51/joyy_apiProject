<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[

            'id'               => $this->id,
            'title'            => $this->title,
            'image'           => $this->image_url,
            'time_ago'        => Carbon::parse($this->created_at)->diffForHumans(),
            // Category data after service details
            // 'category' => [
            //     'id'    => optional($this->category)->id,
            //     'title' => optional($this->category)->title,
            // ],
            
        ];
    }
}
