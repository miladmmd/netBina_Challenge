<?php

namespace Tests;

use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function login($name='milad',$email='m@m.com')
    {
        User::factory()->create([
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make('123456'), // password
        ]);
        $response = $this->json('post', '/api/login', [
            'email' => 'm@m.com',
            'password'=>'123456'
        ]);
        return $response;
    }

    public function createTask()
    {
        return Task::create([
            'title' => 'test',
            'deadline' => fake()->dateTimeBetween('+1 months','+2 months')
        ]);
    }

    public function createExpireTask()
    {
        return Task::create([
            'title' => 'test',
            'deadline' => fake()->dateTimeBetween('-2 months','-1 months')
        ]);
    }

    public function createUser($emial = 't@m.com')
    {
        return User::factory()->create([
            'name' => 'test',
            'email' => $emial,
            'email_verified_at' => now(),
            'password' => Hash::make('123456'), // password
        ]);
    }

    public function assignTask($task,$user_id,$allocator_id,$allocator_email)
    {

        $task->users()->syncWithoutDetaching([$user_id=>['allocator_id'=>$allocator_id,'allocator_email'=>$allocator_email]]);
    }
}
