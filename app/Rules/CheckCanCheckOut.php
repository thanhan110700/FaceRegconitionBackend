<?php

namespace App\Rules;

use App\Services\Client\AttendanceService;
use Illuminate\Contracts\Validation\Rule;

class CheckCanCheckOut implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return app(AttendanceService::class)->canCheckOut();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "To day you haven't already checked in";
    }
}
