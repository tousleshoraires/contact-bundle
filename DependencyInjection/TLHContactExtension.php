<?php

/*
 * This file is part of the TLHContactBundle package.
 *
 * (c) TLH <http://github.com/tousleshoraires>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TLH\ContactBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TLHContactExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('tlh_contact.class', $config['class']);
        $container->setParameter('tlh_contact.form', $config['form']);
        $container->setParameter('tlh_contact.confirmation.enabled', $config['confirmation']['enabled']);
        $container->setParameter('tlh_contact.confirmation.template', $config['confirmation']['template']);
        $container->setParameter('tlh_contact.information.enabled', $config['information']['enabled']);
        $container->setParameter('tlh_contact.information.template', $config['information']['template']);

        if( isset($config['confirmation']['from_email']) ) {
            $container->setParameter('tlh_contact.confirmation.from_email.address', $config['confirmation']['from_email']['address']);
            $container->setParameter('tlh_contact.confirmation.from_email.sender_name', $config['confirmation']['from_email']['sender_name']);
        }
        if( isset($config['information']['from_email']) ) {
            $container->setParameter('tlh_contact.information.from_email.address', $config['information']['from_email']['address']);
            $container->setParameter('tlh_contact.information.from_email.sender_name', $config['information']['from_email']['sender_name']);
        }

        // $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // $loader->load('services.xml');
    }
}
