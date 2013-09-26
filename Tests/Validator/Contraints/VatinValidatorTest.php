<?php

namespace Ddeboer\VatinBundle\Tests\Validator\Constraints;

use Ddeboer\VatinBundle\Validator\Constraints\Vatin;
use Ddeboer\VatinBundle\Validator\Constraints\VatinValidator;
use Ddeboer\Vatin\Validator;

class VatinTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;

    public function setUp()
    {
        $this->context = $this->getMock('\Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
    }

    public function testNull()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->getValidator()->validate(null, new Vatin());
    }

    public function testValid()
    {
        $this->context->expects($this->never())
            ->method('addViolation');

        $this->getValidator()->validate('NL123456789B01', new Vatin());
    }

    public function testValidWithExistence()
    {
        $constraint = new Vatin();
        $constraint->checkExistence = true;

        $validator = $this->getMockBuilder('\Ddeboer\Vatin\Validator')
            ->disableOriginalConstructor()
            ->getMock();

        $validator->expects($this->once())
            ->method('isValid')
            ->with('NL123456789B01', true)
            ->will($this->returnValue(false));

        $this->context->expects($this->once())
            ->method('addViolation');

        $this->getValidator($validator)->validate('NL123456789B01', $constraint);
    }

    protected function getValidator($validator = null)
    {
        $validator = new VatinValidator($validator ?: new Validator());
        $validator->initialize($this->context);

        return $validator;
    }
}