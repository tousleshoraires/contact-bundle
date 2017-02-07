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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Julien Devergnies <julien@tousleshoraires.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tlh_contact');

        $rootNode
            ->children()
                // ->scalarNode('contact_class')->isRequired()->cannotBeEmpty()->end();
                ->scalarNode('class')->defaultValue('TLH\ContactBundle\Entity\Contact')->end()
                ->scalarNode('form')->defaultValue('TLH\ContactBundle\Form\ContactType')->end()
                ->scalarNode('recipient_address')->isRequired()->cannotBeEmpty()->end()
                // ->arrayNode('from_email')
                //     ->addDefaultsIfNotSet()
                //     ->children()
                //         ->scalarNode('address')->defaultValue('webmaster@example.com')->cannotBeEmpty()->end()
                //         ->scalarNode('sender_name')->defaultValue('webmaster')->cannotBeEmpty()->end()
                //     ->end()
                // ->end()
                ->arrayNode('confirmation')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->scalarNode('template')->defaultValue('TLHContactBundle:Contact:email.txt.twig')->end()
                        ->arrayNode('from_email')
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('address')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('sender_name')->isRequired()->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('information')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->scalarNode('template')->defaultValue('TLHContactBundle:Contact:email_information.txt.twig')->end()
                        ->arrayNode('from_email')
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('address')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('sender_name')->isRequired()->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ;

        return $treeBuilder;
    }
}