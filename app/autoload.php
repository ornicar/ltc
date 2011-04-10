<?php

$vendorDir = realpath(__DIR__.'/../vendor');
$srcDir = realpath(__DIR__.'/../src');

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'                        => $vendorDir.'/symfony/src',
    'Doctrine\\Common\\DataFixtures' => $vendorDir.'/doctrine-data-fixtures/lib',
    'Doctrine\\Common'               => $vendorDir.'/doctrine-common/lib',
    'Doctrine\\MongoDB'              => $vendorDir.'/doctrine-mongodb/lib',
    'Doctrine\\ODM\\MongoDB'         => $vendorDir.'/doctrine-mongodb-odm/lib',
    'Doctrine\\ODM\\MongoDB'         => $vendorDir.'/doctrine-mongodb-odm/lib',
    'Gedmo'                          => $vendorDir.'/doctrine-extensions/lib',
    'Zend'                           => $vendorDir.'/zend/library',
    'Assetic'                        => $vendorDir.'/assetic/src',
    'Imagine'                        => $vendorDir.'/imagine/lib',
    'Monolog'                        => $vendorDir.'/monolog/src',
    'Ltc'                            => $srcDir,
    'FOS'                            => $srcDir,
    'FOQ'                            => $srcDir,
    'Stof'                           => $srcDir,
    'Knplabs'                        => $srcDir,
    'Avalanche'                      => $srcDir,
    'JMS'                            => $srcDir,
    'Bundle'                         => $srcDir,
));
$loader->registerPrefixes(array(
    'Twig_Extensions_' => $vendorDir.'/twig-extensions/lib',
    'Twig_'            => $vendorDir.'/twig/lib',
));
$loader->register();
