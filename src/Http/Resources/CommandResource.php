<?php

namespace Xden\ArtGui\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Xden\ArtGui\Dto\CommandUnknown;

class CommandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof CommandUnknown) {
            return [
                'name' => $this->name,
                'error' => 'Not found'
            ];
        }

        return [
            'name' => $this->name,
            'description' => $this->description,
            'synopsis' => $this->synopsis,
            'arguments' => $this->arguments
                ? ArgumentCommandResource::collection($this->arguments)
                : null,
            'options' => $this->options
                ? OptionCommandResource::collection($this->options)
                : null,
        ];
    }
}
