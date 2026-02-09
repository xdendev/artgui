<?php

namespace Xden\ArtGui\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionCommandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'name' => $this->name,
            'description' => $this->description,
            'shortcut' => $this->shortcut,
            'required' => $this->required,
            'array' => $this->array,
            'accept_value' => $this->accept_value,
            'default' => $this->default,
        ];
    }
}
