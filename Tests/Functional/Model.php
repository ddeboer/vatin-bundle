<?php

namespace Ddeboer\VatinBundle\Tests\Functional;

use Ddeboer\VatinBundle\Validator\Constraints\Vatin;

class Model
{
    /**
     * @Vatin
     */
    public $vat;

    /**
     * @Vatin(checkExistence=true)
     */
    public $vatCheckExistence;
}