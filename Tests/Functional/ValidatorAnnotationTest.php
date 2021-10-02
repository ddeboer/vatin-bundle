<?php

namespace Ddeboer\VatinBundle\Tests\Functional;

use Ddeboer\Vatin\Exception\ViesException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorAnnotationTest extends WebTestCase
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    protected function setUp(): void
    {
        static::bootKernel();
        $container = static::$kernel->getContainer();
        $this->validator = $container->get('validator');
    }

    public function testValid()
    {
        $model = new Model();
        $errors = $this->validator->validate($model);
        $this->assertCount(0, $errors);

        $model->vat = 'NL123456789B01';
        $this->assertCount(0, $this->validator->validate($model));
    }

    public function testCheckExistence()
    {
        $model = new Model();
        # invalid value
        $model->vatCheckExistence = '123';
        try {
            $this->assertCount(0, $this->validator->validate($model));
        } catch (ValidatorException $e) {
            if (!$e->getPrevious() instanceof ViesException) {
                throw $e;
            }

            // Ignore unreachable VIES service: at least the check was triggered
        }


        # valid value
        #$model->vatCheckExistence = 'NL123456789B01';
        $model->vatCheckExistence = 'DE239472541'; # see https://www.golem.de/sonstiges/impressum.html
        try {
            $this->assertCount(0, $this->validator->validate($model));
        } catch (ValidatorException $e) {
            if (!$e->getPrevious() instanceof ViesException) {
                throw $e;
            }

            // Ignore unreachable VIES service: at least the check was triggered
        }
    }
}
