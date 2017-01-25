VATIN bundle
============
[![Build Status](https://travis-ci.org/ddeboer/vatin-bundle.svg?branch=master)](https://travis-ci.org/ddeboer/vatin-bundle)
[![Latest Stable Version](https://poser.pugx.org/ddeboer/vatin-bundle/v/stable.png)](https://packagist.org/packages/ddeboer/vatin-bundle)

A Symfony bundle for the [VATIN library](https://github.com/ddeboer/vatin).

Installation
------------

This library is available on [Packagist](https://packagist.org/packages/ddeboer/vatin-bundle):

```bash
$ composer require ddeboer/vatin-bundle
```

Then add the bundle to your application:

```php
// app/AppKernel.php
public function registerBundles()
{
    return [
        ...
        new Ddeboer\VatinBundle\DdeboerVatinBundle(),
        ...
    ];
}
```

Usage
-----

### Validate number format

Use the validator to validate a property on your models. For instance using
annotations:

```php
use Ddeboer\VatinBundle\Validator\Constraints\Vatin;

class Company
{
    /**
     * @Vatin
     */
    protected $vatNumber;
```

Symfony’s validator will now check whether `$vatNumber` has a valid VAT number
format. For more information, see [Symfony’s documentation](http://symfony.com/doc/current/book/validation.html).

### Validate number existence

Additionally, you can check whether the VAT number is in use:

```php
    /**
     * @Vatin(checkExistence=true)
     */
    protected $vatNumber;
```

The validator will now check the VAT number against the
[VAT Information Exchange System (VIES)](http://ec.europa.eu/taxation_customs/vies/faq.html)
SOAP web service. This service’s availability is rather unreliable, so it’s a
good idea to catch the case where it’s unreachable:


```php
use Symfony\Component\Validator\Exception\ValidatorException;

try {
    if ($validator->isValid()) {
        // Happy flow
    }
} catch (ValidatorException $e) {
    // VAT could not be validated because VIES service is unreachable
}
```

### Using the services directly

You can also use this bundle’s services directly. Validate a VAT number’s format:

```php
$validator = $container->get('ddeboer_vatin.vatin_validator');
$bool = $validator->isValid('NL123456789B01');
```

Additionally check whether the VAT number is in use:

```php
$bool = $validator->isValid('NL123456789B01', true);
```

To interact with the VIES webservice:

```php
$vies = $container->get('ddeboer_vatin.vies.client');
$checkVatResponse = $vies->checkVat('NL', '123456789B01');
```

More information
----------------

For more information, see the [VATIN library’s documentation](https://github.com/ddeboer/vatin).
