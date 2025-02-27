<?php

namespace Ddeboer\VatinBundle;

use Ddeboer\Vatin\Validator;
use Ddeboer\Vatin\Vies\Client;
use Ddeboer\VatinBundle\Validator\Constraints\VatinValidator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class DdeboerVatinBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $services = $container->services();

        $services->set('ddeboer_vatin.validator')
            ->class(VatinValidator::class)
            ->arg(0, service('ddeboer_vatin.vatin_validator'))
            ->tag('validator.constraint_validator', [
                'alias' => 'ddeboer_vatin.validator',
            ]);

        $services->set('ddeboer_vatin.vatin_validator')
            ->class(Validator::class)
            ->arg(0, service('ddeboer_vatin.vies.client'));

        $services->set('ddeboer_vatin.vies.client')
            ->class(Client::class);
    }
}
