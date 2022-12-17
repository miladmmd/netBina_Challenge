<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskRouteTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    protected function setUp():void
    {
        parent::setUp();
        \Artisan::call('passport:install');
    }

    public function test_validate_created_task_if_deadline_expire()
    {

        $login = $this->login();
        $response = $this->withHeader('Authorization', 'Bearer ' . $login['token'])
            ->json('post', '/api/task', [
                'title' => 'test',
                'deadline' => '2020-12-11'
            ]);

        $response->assertStatus(422);
        $this->assertEquals('deadline is expired,please select time greater than now',$response['data']['deadline'][0]);
    }
    public function test_create_task_by_user_login()
    {
        $login = $this->login();
        $response = $this->withHeader('Authorization', 'Bearer ' . $login['token'])
            ->json('post', '/api/task', [
                'title' => 'test',
                'deadline' => '2023-12-11'
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'created_by',
            'confirmed_by',
            'deadline',
            'status'
        ]);
    }


    public function test_assign_task()
    {
        $login = $this->login();
        $task = $this->createTask();
        $user = $this->createUser();
        $response = $this->withHeader('Authorization', 'Bearer ' . $login['token'])
            ->json('post', '/api/task/assign', [
                'task_id' => $task['id'],
                'user_id' => $user['id']
            ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'created_by',
            'confirmed_by',
            'deadline',
            'status'
        ]);
    }

    public function test_validate_assign_task_if_deadline_expire()
    {
        $login = $this->login();
        $task = $this->createExpireTask();
        $user = $this->createUser();
        $response = $this->withHeader('Authorization', 'Bearer ' . $login['token'])
            ->json('post', '/api/task/assign', [
                'task_id' => $task['id'],
                'user_id' => $user['id']
            ]);
        $response->assertStatus(422);
        $this->assertEquals('The task approval deadline has been delayed',$response['data']['task_id'][0]);
    }

    public function test_confirm_Task()
    {
        $allocator = $this->createUser('m@m.com');
        $task = $this->createTask();
        $user=$this->createUser();
        $this->assignTask($task,$user['id'],$allocator['id'],$allocator['email']);
        $userLogin = $this->json('post', '/api/login', [
            'email' => $user->email,
            'password'=>'123456'
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $userLogin['token'])

            ->json('post', '/api/task/confirm', [
                'task_id' => $task->id,
                'user_id' => $user['id']
             ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'created_by',
            'confirmed_by',
            'deadline',
            'status'
        ]);

    }

    public function test_validate_confirm_task_if_not_related_to_user()
    {

        $task = $this->createTask();
        $user=$this->createUser();

        $userLogin = $this->json('post', '/api/login', [
            'email' => $user->email,
            'password'=>'123456'
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $userLogin['token'])

            ->json('post', '/api/task/confirm', [
                'task_id' => $task->id,
                'user_id' => $user['id']
            ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' =>[
                'task_id'=>[]
            ]
        ]);

    }
}
