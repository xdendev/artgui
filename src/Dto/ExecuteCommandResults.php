<?php

namespace Xden\ArtGui\Dto;

use Illuminate\Contracts\Support\Arrayable;

final readonly class ExecuteCommandResults implements Arrayable
{
    public function __construct(
        public int $status,
        public string $output,
        public string $command
    )
    {
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'output' => $this->output,
            'command' => $this->command
        ];
    }
}