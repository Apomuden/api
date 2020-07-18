<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /*
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    */
    public function testAuthLogin()
    {
        $response = $this->post('/v1/auth/login',['username'=>'wrong_username','password'=>'secret']);

        $response->assertUnauthorized();
    }
}
