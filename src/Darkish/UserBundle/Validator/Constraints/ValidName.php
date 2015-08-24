<?php

namespace Darkish\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidName extends Constraint
{
    public $message = "
    نام وارد شده معتبر نیست.
    ";

    public function validatedBy()
    {
        return 'darkish_valid_name';
    }
}
