<?php

namespace ICS\LibsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class LibsExtension extends Extension implements PrependExtensionInterface
{
    public static $themes = [
        'cerulean' => [
            'type' => 'sun',
            'fonts' => []
        ],
        'cosmo' => [
            'type' => 'sun',
            'fonts' => [
                'Source_Sans_Pro'
            ]
        ],
        'cyborg' => [
            'type' => 'moon',
            'fonts' => [
                'Roboto'
            ]
        ],
        'darkly' => [
            'type' => 'moon',
            'fonts' => [
                'Lato'
            ]
        ],
        'flatly' => [
            'type' => 'sun',
            'fonts' => [
                'Lato'
            ]
        ],
        'journal' => [
            'type' => 'sun',
            'fonts' => [
                'News_Cycle'
            ]
        ],
        'litera' => [
            'type' => 'sun',
            'fonts' => []
        ],
        'lumen' => [
            'type' => 'sun',
            'fonts' => [
                'Source_Sans_Pro'
            ]
        ],
        'lux' => [
            'type' => 'sun',
            'fonts' => [
                'Nunito_Sans'
            ]
        ],
        'materia' => [
            'type' => 'sun',
            'fonts' => [
                'Roboto'
            ]
        ],
        'minty' => [
            'type' => 'sun',
            'fonts' => [
                'Montserrat'
            ]
        ],
        'morph' => [
            'type' => 'moon',
            'fonts' => [
                'Nunito'
            ]
        ],
        'pulse' => [
            'type' => 'sun',
            'fonts' => []
        ],
        'quartz' => [
            'type' => 'sun',
            'fonts' => []
        ],
        'sandstone' => [
            'type' => 'sun',
            'fonts' => [
                'Roboto'
            ]
        ],
        'simplex' => [
            'type' => 'sun',
            'fonts' => [
                'Open_Sans'
            ]
        ],
        'sketchy' => [
            'type' => 'sun',
            'fonts' => [
                'Neucha',
                'Cabin_Sketch'
            ]
        ],
        'slate' => [
            'type' => 'moon',
            'fonts' => []
        ],
        'solar' => [
            'type' => 'moon',
            'fonts' => [
                'Source_Sans_Pro'
            ]
        ],
        'spacelab' => [
            'type' => 'sun',
            'fonts' => [
                'Open_Sans'
            ]
        ],
        'superhero' => [
            'type' => 'moon',
            'fonts' => [
                'Lato'
            ]
        ],
        'united' => [
            'type' => 'sun',
            'fonts' => [
                'Ubuntu'
            ]
        ],
        'vapor' => [
            'type' => 'moon',
            'fonts' => [
                'Lato'
            ]
        ],
        'yeti' => [
            'type' => 'sun',
            'fonts' => [
                'Open_Sans'
            ]
        ],
        'zephyr' => [
            'type' => 'sun',
            'fonts' => [
                'Inter'
            ]
        ],
    ];

    public function load(array $configs, ContainerBuilder $container)
    {

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config/'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $configs = $this->processConfiguration($configuration, $configs);

        $container->setParameter('libs', $configs);
    }

    public function prepend(ContainerBuilder $container)
    {

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config/'));

        // Loading security config
        $loader->load('security.yaml');

        // Loading specific bundle config
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());

        // resolve config parameters e.g. %kernel.debug% to its boolean value
        $resolvingBag = $container->getParameterBag();
        $configs = $resolvingBag->resolveValue($configs);

        // use the Configuration class to generate a config array with
        // the settings "acme_hello"
        $libconfig = $this->processConfiguration(new Configuration(), $configs);

        if (isset($bundles['NavigationBundle'])) {
            $loader->load('navigation.yaml');
            $config['navbars']['main']['tools']['themeButton']['childs'] = [];
            $i = 10;
            foreach ($libconfig['bootstrapthemes'] as $theme) {
                $t = [];
                $t['lib'] = $theme;
                $t['order'] = $i;
                $t['icon'] = 'fas fa-' . LibsExtension::$themes[$theme]['type'];
                $t['attrs']['data-theme-select'] = $theme;
                $t['attrs']['data-theme'] = "select";
                $config['navbars']['main']['tools']['themeButton']['childs'][] = $t;
                $i++;
            }

            foreach ($container->getExtensions() as $name => $extension) {
                switch ($name) {
                    case 'navigation':
                        $container->prependExtensionConfig($name, $config);
                        break;
                }
            }
        }

        if (isset($bundles['UserHelpBundle'])) {
            $loader->load('userhelp.yaml'); 
        }
    }
}
