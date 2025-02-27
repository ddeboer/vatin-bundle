<?php

namespace Ddeboer\VatinBundle\Tests\Validator\Constraints;

use Ddeboer\Vatin\Validator;
use Ddeboer\Vatin\ValidatorInterface;
use Ddeboer\Vatin\Vies\Client;
use Ddeboer\VatinBundle\Validator\Constraints\Vatin;
use Ddeboer\VatinBundle\Validator\Constraints\VatinValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<VatinValidator>
 */
class ValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new VatinValidator(new Validator());
    }

    public function testNullIsValid(): void
    {
        $this->validator->validate(null, new Vatin());

        $this->assertNoViolation();
    }

    public function testEmptyStringIsValid(): void
    {
        $this->validator->validate('', new Vatin());

        $this->assertNoViolation();
    }

    public function testValid(): void
    {
        $this->validator->validate('NL123456789B01', new Vatin());

        $this->assertNoViolation();
    }

    public function testInvalid(): void
    {
        $this->validator->validate('123', new Vatin());

        $this->buildViolation('This is not a valid VAT identification number')
            ->assertRaised();
    }

    public function testValidWithExistence(): void
    {
        $validator = $this->getMockBuilder(ValidatorInterface::class)
            ->getMock();

        $validator->expects($this->once())
            ->method('isValid')
            ->with('NL123456789B01', true)
            ->willReturn(false);

        $this->validator = new VatinValidator($validator);
        $this->validator->initialize($this->context);

        $constraint = new Vatin();
        $constraint->checkExistence = true;

        $this->validator->validate('NL123456789B01', $constraint);

        $this->buildViolation('This is not a valid VAT identification number')
            ->assertRaised();
    }

    public function testFailedClient(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new VatinValidator(new Validator(new Client('http://localhost')));
        $validator->validate('NL123456789B01', new Vatin(message: 'Invalid VAT', checkExistence: true));
    }
}
