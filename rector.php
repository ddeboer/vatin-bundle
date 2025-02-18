<?php

declare(strict_types = 1);

use Rector\Config\RectorConfig;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    ->withSymfonyContainerXml(
        __DIR__ . '/var/cache/test/Ddeboer_VatinBundle_Tests_Functional_AppKernelTestDebugContainer.xml'
    )
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withAttributesSets(
        symfony: true,
    )
    ->withPhpSets(
        php81: true,
    )
    ->withSets([
        SymfonySetList::SYMFONY_60,
        SymfonySetList::SYMFONY_61,
        SymfonySetList::SYMFONY_62,
        SymfonySetList::SYMFONY_63,
        SymfonySetList::SYMFONY_64,
    ]);
