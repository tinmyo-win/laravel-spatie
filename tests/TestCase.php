<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function getToken($email = 'mgmg@g.com', $password = 'password') {
        $response = $this->login($email, $password);
        return $response['token'];
    }

    public function login($email = 'mgmg@g.com', $password = 'password') {
        $param = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->post('/api/login', $param);

        return $response;
    }
}
