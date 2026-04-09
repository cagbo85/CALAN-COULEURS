<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Session;

abstract class TestCase extends BaseTestCase
{
    /**
     * Poste un formulaire en initialisant la session + token CSRF.
     */
    protected function postAsForm(string $uri, array $data = [], array $headers = [])
    {
        Session::start();

        return $this->post($uri, $data + [
            '_token' => csrf_token(),
        ], $headers);
    }
}
