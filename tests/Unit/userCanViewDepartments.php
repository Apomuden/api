<?php

namespace Tests\Unit;

use App\Models\Patient;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\JWTAuth;


class userCanViewDepartments extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $user=User::find('3a3af595-a18d-4de8-b9fc-86f354ba7381');

        $token=auth('api')->login($user);

        $this->json('get','v1/setups/departments',[], ['Authorization' => "Bearer $token"])
           ->assertOk();
    }
}
