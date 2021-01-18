<?php

namespace App\Http\Resources;

use App\Classes\Helper\GCSHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar_letter' => $this->avatar_letter,
            'avatar_color' => $this->avatar_color,
            'avatar' => GCSHelper::getUrl($this->avatar),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
