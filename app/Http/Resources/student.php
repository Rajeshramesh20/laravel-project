<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubjectResource;

class student extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'age' => $this->age,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'mobile_number' => $this->mobile_number,
            'class' => $this->class,
            'batch' => $this->batch,
            'medium' => $this->medium,
            'group_id' => $this->group_id,
            'subjects' => SubjectResource::collection($this->subjects),
        ];
    }
}
