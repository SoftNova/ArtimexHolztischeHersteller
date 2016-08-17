<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/17/2016
 * Time: 11:37 AM
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;

class MinMaxChoices extends Constraint
{

    public $min = 1;
    public $max = 4;

    public $minMessage="app.samples.min.message";
    public $maxMessage="app.samples.max.message";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

}