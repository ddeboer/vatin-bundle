<?php

namespace Ddeboer\VatinBundle\Tests\Functional\Tests;

use Ddeboer\Vatin\Exception\ViesException;
use Ddeboer\VatinBundle\Tests\Functional\Model\Model;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorAttributeTest extends WebTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = static::getContainer()->get('test.validator');
    }

    public function testValid(): void
    {
        $model = new Model();
        $errors = $this->validator->validate($model);
        $this->assertEquals(0, count($errors));

        $model->vat = 'NL123456789B01';
        $this->assertCount(0, $this->validator->validate($model));
    }

    public function testCheckExistence(): void
    {
        $model = new Model();
        $model->vatCheckExistence = '123';
        $this->assertCount(1, $this->validator->validate($model));

        $model->vatCheckExistence = 'NL123456789B01';
        try {
            $this->assertCount(1, $this->validator->validate($model));
        } catch (ValidatorException $e) {
            if (!$e->getPrevious() instanceof ViesException) {
                throw $e;
            }

            // Ignore unreachable VIES service: at least the check was triggered
        }
    }
}
