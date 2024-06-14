<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfilePublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,                              // @phpstan-ignore-line
            'lastname' => $this->lastname,                  // @phpstan-ignore-line
            'firstname' => $this->firstname,                // @phpstan-ignore-line
            'image' => $this->image,                        // @phpstan-ignore-line
            'created_at' => $this->created_at,              // @phpstan-ignore-line
            'updated_at' => $this->updated_at               // @phpstan-ignore-line
        ];
    }
}
