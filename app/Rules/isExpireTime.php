<?php
namespace App\Rules;

use App\Traits\ValidateTasks;
use Illuminate\Contracts\Validation\InvokableRule;

class isExpireTime implements InvokableRule
{
    use ValidateTasks;
    protected $taskServices;



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

        if($this->isExpireTime($value)){
            $fail('deadline is expired,please select time greater than now');
        }
    }
}
