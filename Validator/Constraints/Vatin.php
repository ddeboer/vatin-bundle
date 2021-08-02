<?php

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * VAT identification number constraint
 *
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Vatin extends Constraint
{
    public $message = 'This is not a valid VAT identification number';
    public $checkExistence = false;

    /**
     * Vatin constructor.
     *
     * @param array|null  $options
     * @param string|null $message
     * @param bool|null   $checkExistence
     * @param array|null  $groups
     * @param null        $payload
     */
    public function __construct(
        array $options = null,
        string $message = null,
        bool $checkExistence = null,
        array $groups = null,
        $payload = null
    ) {
        if ($message) {
            $options['message'] = $message;
        }
        if ($checkExistence) {
            $options['checkExistence'] = $checkExistence;
        }

        parent::__construct($options ?? [], $groups, $payload);
    }

    public function validatedBy()
    {
        return 'ddeboer_vatin.validator';
    }
}
