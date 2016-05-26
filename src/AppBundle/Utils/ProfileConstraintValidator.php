<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/16/2016
 * Time: 3:58 PM
 */

namespace AppBundle\Utils;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ProfileConstraintValidator extends  ConstraintValidator
{
    /** @var string $value */
    public function validate($value, Constraint $constraint)
    {
        if ($value===null || $value === ""){
            return;
        }

        $value = preg_replace('/\s+/', '', $value);
        $regEx = '/^[0-9]+x{1}[0-9]+$/';
        $invalid = preg_match($regEx, $value)=== 1 ? false : true;
        if ($invalid){
            $this->context->addViolation($constraint->message);
        }
    }
}