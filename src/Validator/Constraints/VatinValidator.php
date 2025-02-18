<?php

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Ddeboer\Vatin\Exception\ViesExceptionInterface;
use Ddeboer\Vatin\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Validate a VAT identification number using the ddeboer/vatin library
 */
final class VatinValidator extends ConstraintValidator
{
    /**
     * Constructor
     *
     * @param ValidatorInterface $validator VATIN validator
     */
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ('' === $value || !is_string($value) || !$constraint instanceof Vatin) {
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
     * @param bool $checkExistence Also check whether the VAT number exists
     */
    private function isValidVatin(string $value, bool $checkExistence): bool
    {
        try {
            return $this->validator->isValid($value, $checkExistence);
        } catch (ViesExceptionInterface $e) {
            throw new ValidatorException('VIES service unreachable', previous: $e);
        }
    }
}
