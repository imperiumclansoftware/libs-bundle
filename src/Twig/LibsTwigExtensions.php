<?php

namespace ICS\LibsBundle\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Environment;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use ICS\SsiBundle\Entity\Account;
use ICS\LibsBundle\DependencyInjection\LibsExtension;

class LibsTwigExtensions extends AbstractExtension
{
    private $config;
    /**
     * @var Account
     */
    private $user;
    private $kernel;
    private $security;

    public function __construct(ParameterBagInterface $params, KernelInterface $kernel, Security $security)
    {
        $this->config = $params->get('libs');
        $this->security = $security;
        $this->kernel = $kernel;
    }

    public function getFilters()
    {
        return [];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('renderLibsCSS', [$this, 'renderCss'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('renderLibsJS', [$this, 'renderJs'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('renderLibs', [$this, 'renderLibs'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('renderBootstrapTheme', [$this, 'renderBootstrapTheme'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),

        ];
    }

    public function renderCss(Environment $env)
    {
        if ($this->config['cdn']) {
            return $env->render('@Libs/cdn/css.html.twig', [
                'config' => $this->config
            ]);
        } else {
            return $env->render('@Libs/local/Css.html.twig', [
                'config' => $this->config
            ]);
        }
    }

    public function renderJs(Environment $env)
    {
        if ($this->config['cdn']) {
            return $env->render('@Libs/cdn/js.html.twig', [
                'config' => $this->config
            ]);
        } else {
            return $env->render('@Libs/local/js.html.twig', [
                'config' => $this->config
            ]);
        }
    }

    public function renderLibs(Environment $env)
    {
        return $this->renderCss($env) . $this->renderJs($env);
    }

    public function renderBootstrapTheme(Environment $env)
    {
        $themeName = "";
        $this->user = $this->security->getUser();
        
        if ($this->user != null && $this->user->getProfile() != null && $this->user->getProfile()->getParameter('theme') != null) {
            $themeName=$this->user->getProfile()->getParameter('theme');
        } else if ($this->config['bootstrapDefaultTheme'] != null && in_array($this->config['bootstrapDefaultTheme'], $this->config['bootstrapthemes'])) {
            $themeName = $this->config['bootstrapDefaultTheme'];
        }

        $themePath = null;
        $fonts = [];
        if ($themeName != "") {
            if ($this->config['cdn']) {
                $themePath = "bundles/libs/local/bootstrap/themes/" . $themeName . "/bootstrap.min.css";
            } else {
                $fonts = $this->getFontsList($themeName);
                $themePath = "bundles/libs/local/bootstrap/themes/" . $themeName . "/bootstrap.min.css";
            }
        }

        return $env->render('@Libs/theme.css.twig', [
            'themePath' => $themePath,
            'fonts' => $fonts
        ]);
    }

    public function getSelectThemeJs()
    {
        
    }

    public function getFontsList($themeName)
    {
        if (key_exists($themeName, LibsExtension::$themes)) {
            return LibsExtension::$themes[$themeName]['fonts'];
        }

        return [];
    }
}
