<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Task::factory(15)->create();
        foreach (Task::all() as $task){
            $users = User::inRandomOrder()->take(rand(1,10))->pluck('id');
            foreach ($users as $user) {
                $allocator = User::inRandomOrder()->first();
                $task->users()->attach($user,['allocator_id'=>$allocator->id,'allocator_email'=>$allocator->email]);
                $task->update([
                    'last_assigned_user_id'=>null,
                ]);
            }
        }
    }
}
