<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'file_name'      => $this->file_name,
            'status'         => $this->status,
            'initiated_at'   => $this->initiated_at,
            'completed_at'   => $this->completed_at,
            'error_message'  => $this->error_message,
            'user' => [
                     'name'  => $this->user->name ?? null,
            ],
        ];

    
}
}