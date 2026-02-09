<?php

namespace Xden\ArtGui\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommandNotFoundException extends NotFoundHttpException
{
    public function __construct(string $commandName)
    {
        parent::__construct("Artisan command '{$commandName}' not found.");
    }
}