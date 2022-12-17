<?php
namespace App\Rules;

use App\Services\TaskServiceInterface;
use App\Traits\ValidateTasks;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class TaskIsConfirmed implements InvokableRule
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

        if($this->isConfirmed($value)){
            $fail('this task is Confirmed, you can not assign this');
        }

    }


}
