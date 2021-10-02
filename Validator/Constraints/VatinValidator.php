<?php

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Ddeboer\Vatin\Exception\ViesException;
use Ddeboer\Vatin\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Validate a VAT identification number using the ddeboer/vatin library
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

        try {
            #var_dump('Check '.$value. ' '.$constraint->checkExistence);
            if ($this->isValidVatin($value, $constraint->checkExistence)) {
                return;
            }

            $this->context->buildViolation($constraint->message)->addViolation();
        }
        catch (\Exception $e)
        {
         #var_dump($e->getMessage());
         #var_dump("error build violation for ".$value);
         $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

    /**
     * Is the value a valid VAT identification number?
     */
    private function isValidVatin(string $value, bool $checkExistence): bool
    {
        try {
            return $this->validator->isValid($value, $checkExistence);
        } catch (ViesException $e) {
            throw new ValidatorException('VIES service unreachable', null, $e);
        }
    }
}
