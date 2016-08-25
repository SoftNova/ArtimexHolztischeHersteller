<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/17/2016
 * Time: 11:42 AM
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MinMaxChoicesValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {

        $count = count($value);
        if ($constraint->min !== null && $count < $constraint->min) {
            $this->context->addViolation($constraint->minMessage);
            return;
        }
        if ($constraint->max !== null && $count > $constraint->max) {
            $this->context->addViolation($constraint->maxMessage);
            return;
        }
    }
}