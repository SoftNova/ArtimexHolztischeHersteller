<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/15/2016
 * Time: 1:44 AM
 */

namespace AppBundle\Utils;


use Symfony\Component\Validator\Constraint;

class ImgConstraint extends Constraint
{
    public $message = "You can only upload jpg, jpeg, png or giff files";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}