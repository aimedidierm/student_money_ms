<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueEmailAcrossTables implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $count = DB::table('schools')->where('email', $value)->count();
        $count += DB::table('canteens')->where('email', $value)->count();
        $count += DB::table('schools')->where('email', $value)->count();
        $count += DB::table('guardians')->where('email', $value)->count();

        if ($count > 0) {
            $fail("The $attribute has already been taken.");
        }
    }
}
