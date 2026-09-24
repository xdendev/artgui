<?php

namespace Xden\ArtGui\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class BasicAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $username = (string) config('artgui.auth.username');
        $password = (string) config('artgui.auth.password');

        if ($username === '' || $password === '') {
            return response('ArtGui credentials are not configured.', Response::HTTP_FORBIDDEN);
        }

        $validUser = hash_equals($username, (string) $request->getUser());
        $validPassword = hash_equals($password, (string) $request->getPassword());

        if (!$validUser || !$validPassword) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED, [
                'WWW-Authenticate' => 'Basic realm="ArtGui", charset="UTF-8"',
            ]);
        }

        return $next($request);
    }
}
