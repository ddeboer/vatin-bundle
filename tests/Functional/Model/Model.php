<?php

namespace Ddeboer\VatinBundle\Tests\Functional\Model;

use Ddeboer\VatinBundle\Validator\Constraints\Vatin;

class Model
{
    #[Vatin]
    public string $vat;

    #[Vatin(checkExistence: true)]
    public string $vatCheckExistence;
}
