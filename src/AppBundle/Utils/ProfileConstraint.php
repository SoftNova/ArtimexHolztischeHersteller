<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/16/2016
 * Time: 3:58 PM
 */

namespace AppBundle\Utils;

use Symfony\Component\Validator\Constraint;

class ProfileConstraint extends Constraint
{
    public $message = "Invalid data added. Please recheck.";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}