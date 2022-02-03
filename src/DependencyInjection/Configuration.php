<?php
namespace ICS\LibsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {

        $treeBuilder = new TreeBuilder('libs');
        $treeBuilder->getRootNode()->children()
            ->booleanNode('cdn')->defaultValue(true)->end()
            ->booleanNode('bootstrap')->defaultValue(true)->end()
            ->booleanNode('jquery')->defaultValue(true)->end()
            ->booleanNode('fontawesome')->defaultValue(true)->end()
            ->scalarNode('bootstrapDefaultTheme')->defaultValue(null)->end()
            ->arrayNode('bootstrapthemes')
                ->enumPrototype()
                    ->values([
                        'cerulean',
                        'cosmo',
                        'cyborg',
                        'darkly',
                        'flatly',
                        'journal',
                        'litera',
                        'lumen',
                        'lux',
                        'materia',
                        'minty',
                        'morph',
                        'pulse',
                        'quartz',
                        'sandstone',
                        'simplex',
                        'sketchy',
                        'slate',
                        'solar',
                        'spacelab',
                        'superhero',
                        'united',
                        'vapor',
                        'yeti',
                        'zephyr'
                    ])
                ->end()
                ->defaultValue([
                    'cerulean',
                    'cosmo',
                    'cyborg',
                    'darkly',
                    'flatly',
                    'journal',
                    'litera',
                    'lumen',
                    'lux',
                    'materia',
                    'minty',
                    'morph',
                    'pulse',
                    'quartz',
                    'sandstone',
                    'simplex',
                    'sketchy',
                    'slate',
                    'solar',
                    'spacelab',
                    'superhero',
                    'united',
                    'vapor',
                    'yeti',
                    'zephyr',
                ])
            ->end()
                
        ;

        return $treeBuilder;
    }

}
