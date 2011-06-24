<?php

$vendorDir = realpath(__DIR__.'/../vendor');
$srcDir = realpath(__DIR__.'/../src');

require $vendorDir.'/symfony/src/Symfony/Component/ClassLoader/ApcUniversalClassLoader.php';
use Symfony\Component\ClassLoader\ApcUniversalClassLoader;

$loader = new ApcUniversalClassLoader('ltc.cl.');
$loader->registerNamespaces(array(
    'Symfony'                        => array($vendorDir.'/symfony/src', $srcDir),
    'Doctrine\\Common\\DataFixtures' => $vendorDir.'/doctrine-data-fixtures/lib',
    'Doctrine\\Common'               => $vendorDir.'/doctrine-common/lib',
    'Doctrine\\MongoDB'              => $vendorDir.'/doctrine-mongodb/lib',
    'Doctrine\\ODM\\MongoDB'         => $vendorDir.'/doctrine-mongodb-odm/lib',
    'Gedmo'                          => $vendorDir.'/doctrine-extensions/lib',
    'Zend'                           => $vendorDir.'/zend/library',
    'ZendPaginatorAdapter'           => $vendorDir.'/zend-paginator-adapter/src',
    'Assetic'                        => $vendorDir.'/assetic/src',
    'Imagine'                        => $vendorDir.'/imagine/lib',
    'Monolog'                        => $vendorDir.'/monolog/src',
    'Metadata'                       => $vendorDir.'/metadata/src',
    'Gaufrette'                      => $vendorDir.'/gaufrette/src',
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
    'Twig_'            => $vendorDir.'/twig/lib',
    'Elastica_'        => $vendorDir.'/elastica/lib',
));
$loader->register();
