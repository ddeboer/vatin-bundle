<?php

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * VAT identification number constraint
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Vatin extends Constraint
{
    public string $message = 'This is not a valid VAT identification number';
    public bool $checkExistence = false;

    /**
     * Vatin constructor.
     *
     * {@inheritDoc}
     */
    public function __construct(
        array $options = [],
        ?string $message = null,
        ?bool $checkExistence = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        $this->message = $message ?? $this->message;
        $this->checkExistence = $checkExistence ?? $this->checkExistence;
    }

    public function validatedBy(): string
    {
        return 'ddeboer_vatin.validator';
    }
}
