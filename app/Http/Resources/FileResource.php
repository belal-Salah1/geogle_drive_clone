<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_folder' => $this->is_folder,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'size' => $this->size,
            'path' => $this->path,
            'owner' => $this->owner,
            'created_by' => $this->created_by,
            'parent_id' => $this->parent_id,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'mime' => $this->mime,

        ];
    }
}
