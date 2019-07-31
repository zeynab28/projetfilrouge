<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'twig.form.renderer' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/form/FormRendererInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/form/FormRenderer.php';

return $this->privates['twig.form.renderer'] = new \Symfony\Component\Form\FormRenderer(($this->privates['twig.form.engine'] ?? $this->load('getTwig_Form_EngineService.php')), ($this->services['security.csrf.token_manager'] ?? $this->load('getSecurity_Csrf_TokenManagerService.php')));
