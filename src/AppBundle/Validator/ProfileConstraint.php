<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/16/2016
 * Time: 3:58 PM
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

class ProfileConstraint extends Constraint
{
    public $message = "app.leg.constraint";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}