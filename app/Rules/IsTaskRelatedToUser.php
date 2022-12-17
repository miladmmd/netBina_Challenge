<?php

namespace App\Rules;

use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use App\Traits\ValidateTasks;
use Illuminate\Contracts\Validation\InvokableRule;

class IsTaskRelatedToUser implements InvokableRule
{
    use ValidateTasks;


    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $user_id = auth()->user()->id;

        if(!$this->isTaskRelatedToUser($user_id,$value)){
            $fail('this task is not assign to you,you can not confirmed this.');
        }

    }
}
