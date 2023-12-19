<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueDayIds implements Rule
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
    // Extract day_ids from the weekhours array
    $dayIds = array_column($value, 'day_id');

    // Ensure that the day_ids are unique
    return count($dayIds) === count(array_unique($dayIds));
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */

  public function message()
  {
    return 'The day_id values in the weekhours array must be unique.';
  }

}
