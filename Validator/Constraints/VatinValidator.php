<?php

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Ddeboer\Vatin\Validator;

/**
 * Validate a VAT identification number using the ddeboer/vatin library
 *
 */
class VatinValidator extends ConstraintValidator
{
    /**
     * VATIN validator
     *
     * @var Validator
     */
    private $validator;

    /**
     * Constructor
     *
     * @param Validator $validator VATIN validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if ($this->isValidVatin($value, $constraint->checkExistence)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }

    /**
     * Is the value a valid VAT identification number?
     *
     * @param string $value          Value
     * @param bool   $checkExistence Also check whether the VAT number exists
     *
     * @return bool
     */
    private function isValidVatin($value, $checkExistence)
    {
        return $this->validator->isValid($value, $checkExistence);
    }
}
