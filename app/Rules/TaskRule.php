<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TaskRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $accepted_values = ["Pending", 'In Progress', 'Cancelled', 'Completed'];
        return in_array($value, $accepted_values) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid status.';
    }
}
