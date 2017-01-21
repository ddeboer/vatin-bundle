<?php

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * VAT identification number constraint
 *
 * @Annotation
 */
class Vatin extends Constraint
{
    public $message = 'This is not a valid VAT identification number';
    public $checkExistence = false;

    public function validatedBy()
    {
        return 'ddeboer_vatin.validator';
    }
}
