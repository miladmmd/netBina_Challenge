<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp():void
    {
        parent::setUp();
        \Artisan::call('passport:install');
    }

    public function test_login()
    {
        $response = $this->login();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token' =>'token'
        ]);
    }
}
