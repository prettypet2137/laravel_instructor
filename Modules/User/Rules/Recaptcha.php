<?php

namespace Modules\User\Rules;

use Illuminate\Contracts\Validation\Rule;
use Request;

class Recaptcha implements Rule
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
        $secret = config('recaptcha.api_secret_key'); 
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        $recaptchaResponse = $recaptcha
            ->setScoreThreshold(0.7)
            ->verify($value, Request::ip());
            return true;
        return $recaptchaResponse->isSuccess();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Recaptcha is wrong!';
    }
}
