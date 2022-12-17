<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRouteTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp():void
    {
        parent::setUp();
        \Artisan::call('passport:install');
    }

    public function test_user_route()
    {
        $login = $this->login();
        $this->createTask();
        $response = $this->withHeader('Authorization', 'Bearer ' . $login['token'])
            ->json('get', '/api/user/all');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'email',
                'tasks',
                'created_task'
            ]
        ]);
    }

}
