<?php

namespace Modules\Users\App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'created_at' => now($this->created_at)->diffForHumans(),
            'updated_at' => now($this->updated_at)->diffForHumans(),
        ];
    }
}