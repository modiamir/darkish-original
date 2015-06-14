<?php

namespace Darkish\Validator\Customer\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsCustomeremail extends Constraint
{
    public $message = 'پست الکترونیکی معتبر نیست.';
}
