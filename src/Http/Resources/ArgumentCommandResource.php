<?php

namespace Xden\ArtGui\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArgumentCommandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'name' => $this->name,
            'description' => $this->description,
            'default' => $this->default,
            'required' => $this->required,
            'array' => $this->array,
        ];
    }
}
