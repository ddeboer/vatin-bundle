<?php

namespace Ddeboer\VatinBundle\Tests\Functional;

use Ddeboer\VatinBundle\Validator\Constraints\Vatin;

class Model
{
    /**
     * @Vatin
     */
    #[Vatin]
    public $vat;

    /**
     * @Vatin(checkExistence=true)
     */
    #[Vatin(checkExistence: true)]
    public $vatCheckExistence;
}
