<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailOrPhone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);
        $isPhone = preg_match('/^\+?[0-9\s\-\(\)]{7,}$/', $value);

        if(!$isEmail || !$isPhone){

            $fail('Enter a valid email or phone number');
        }
    }
}
