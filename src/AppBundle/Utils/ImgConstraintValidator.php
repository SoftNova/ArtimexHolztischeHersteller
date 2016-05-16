<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/15/2016
 * Time: 1:46 AM
 */

namespace AppBundle\Utils;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImgConstraintValidator extends ConstraintValidator
{
    /** @var UploadedFile $value */
    public function validate($value, Constraint $constraint)
    {
        if ($value===null){
            return;
        }
        $guessType = $value->getClientOriginalExtension();
        if (!in_array($guessType, Utils::ALLOWED_IMG_EXT)){
            $this->context->addViolation($constraint->message);
        }
    }
}