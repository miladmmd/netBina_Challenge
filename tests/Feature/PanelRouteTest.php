<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PanelRouteTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp():void
    {
        parent::setUp();
        \Artisan::call('passport:install');
    }
    public function test_get_panel_requirment()
    {
        $login = $this->login();
        $response = $this->withHeader('Authorization', 'Bearer ' . $login['token'])
            ->json('get', '/api/panel');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'tasks',
        ]);

    }
}
