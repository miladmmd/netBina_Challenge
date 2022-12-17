<?php
namespace App\Rules;

use App\Traits\ValidateTasks;
use Illuminate\Contracts\Validation\InvokableRule;

class TaskIsDelay implements InvokableRule
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

        if($this->isDeadlineDelay($value)){
            $fail('The task approval deadline has been delayed');
        }
    }
}
