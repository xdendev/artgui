<?php

namespace Xden\ArtGui\Tests\Feature;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Xden\ArtGui\Tests\TestCase;

final class GuiAccessTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:' . base64_encode(str_repeat('a', 32)));
        $app['config']->set('artgui.enabled', true);
        $app['config']->set('artgui.auth.username', 'tester');
        $app['config']->set('artgui.auth.password', 'secret');
        $app['config']->set('artgui.commands', ['info' => ['inspire', 'artgui:test-echo']]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->app['Illuminate\Contracts\Console\Kernel']->command(
            'artgui:test-echo {words?*} {--bank=}',
            function () {
                $this->line('words=' . implode(',', $this->argument('words')));
                $this->line('bank=' . ($this->option('bank') ?? 'null'));
            }
        );
    }

    public function test_request_without_credentials_gets_basic_challenge(): void
    {
        $this->get('/artgui')
            ->assertUnauthorized()
            ->assertHeader('WWW-Authenticate', 'Basic realm="ArtGui", charset="UTF-8"');
    }

    public function test_request_with_wrong_password_is_rejected(): void
    {
        $this->withBasicAuth('tester', 'wrong')->get('/artgui')->assertUnauthorized();
    }

    public function test_request_with_valid_credentials_opens_gui(): void
    {
        $this->withBasicAuth('tester', 'secret')->get('/artgui')->assertOk();
    }

    public function test_gui_is_forbidden_when_credentials_are_not_configured(): void
    {
        config()->set('artgui.auth.username', null);
        config()->set('artgui.auth.password', null);

        $this->withBasicAuth('', '')->get('/artgui')->assertForbidden();
    }

    public function test_command_outside_whitelist_is_not_found(): void
    {
        $this->withBasicAuth('tester', 'secret')->postJson('/artgui/list')->assertNotFound();
    }

    public function test_command_runs_without_optional_value_option(): void
    {
        $response = $this->withBasicAuth('tester', 'secret')
            ->postJson('/artgui/artgui:test-echo', ['words' => 'a  b c'])
            ->assertOk()
            ->assertJsonPath('status', 0);

        $this->assertStringContainsString('words=a,b,c', $response->json('output'));
        $this->assertStringContainsString('bank=null', $response->json('output'));
    }

    public function test_command_receives_option_value(): void
    {
        $response = $this->withBasicAuth('tester', 'secret')
            ->postJson('/artgui/artgui:test-echo', ['bank' => 'vtb'])
            ->assertOk();

        $this->assertStringContainsString('bank=vtb', $response->json('output'));
    }
}
