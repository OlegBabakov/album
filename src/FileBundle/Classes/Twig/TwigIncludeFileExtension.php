<?php

namespace FileBundle\Classes\Twig;

class TwigIncludeFileExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            'include_file' => new \Twig_SimpleFunction('include_file', [$this, 'includeFile'])
        ];
    }

    public function includeFile($path) {
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return null;
    }

    public function getName()
    {
        return 'include_file_extension';
    }
}