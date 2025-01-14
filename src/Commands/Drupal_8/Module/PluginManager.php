<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Module;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:module:plugin-manager command.
 */
class PluginManager extends BaseGenerator {

  protected $name = 'd8:module:plugin-manager';
  protected $description = 'Generates plugin-manager module';
  protected $alias = 'plugin-manager';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
      'dependencies' => ['Dependencies (comma separated)', ''],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['dependencies']) {
      $vars['dependencies'] = explode(',', $vars['dependencies']);
    }

    $vars['class_prefix'] = $this->human2class($vars['machine_name']);

    $templates = [
      'model.drush.inc.twig',
      'model.info.yml.twig',
      'model.services.yml.twig',
      'src/Annotation/Model.php.twig',
      'src/ModelInterface.php.twig',
      'src/ModelPluginBase.php.twig',
      'src/ModelPluginManager.php.twig',
      'src/Plugin/Model/Example.php.twig',
    ];

    $templates_path = 'd8/module/plugin-manager/';

    $path_placeholders = ['model', 'Model'];
    $path_replacements = [$vars['machine_name'], $vars['class_prefix']];
    foreach ($templates as $template) {
      $path = $vars['machine_name'] . '/' . str_replace($path_placeholders, $path_replacements, $template);
      $path = preg_replace('#\.twig$#', '', $path);
      $this->files[$path] = $this->render($templates_path . $template, $vars);
    }

  }

}
