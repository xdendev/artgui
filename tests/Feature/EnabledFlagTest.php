<?php

namespace Xden\ArtGui\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Xden\ArtGui\Tests\TestCase;

final class EnabledFlagTest extends TestCase
{
    public function test_routes_are_not_registered_by_default(): void
    {
        $this->assertFalse(Route::has('artgui.index'));
        $this->assertFalse(Route::has('artgui.run'));
    }

    public function test_command_list_is_empty_by_default(): void
    {
        $this->assertSame([], config('artgui.commands'));
    }
}
