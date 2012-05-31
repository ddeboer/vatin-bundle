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
    protected $validator;

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
    public function isValid($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if ($this->isValidVatin($value, $constraint->checkExistence)) {
            return;
        }

        $this->setMessage($constraint->message);
    }

    /**
     * Is the value a valid VAT identification number?
     *
     * @param string $value Value
     *
     * @return bool
     */
    protected function isValidVatin($value, $checkExistence)
    {
        return $this->validator->isValid($value, $checkExistence);
    }
}