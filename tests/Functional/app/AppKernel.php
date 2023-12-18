<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Ddeboer\VatinBundle\DdeboerVatinBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        if (self::MAJOR_VERSION >= 7) {
            $loader->load(__DIR__ . '/config/config_7.yml');
        } else {
            $loader->load(__DIR__ . '/config/config.yml');
        }
    }
}
