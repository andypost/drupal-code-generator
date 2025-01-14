<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d7:theme-info command.
 */
class ThemeInfo extends BaseGenerator {

  protected $name = 'd7:theme-info';
  protected $description = 'Generates Drupal 7 info file for a theme';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Theme name', [$this, 'defaultName']],
      'machine_name' => ['Theme machine name', [$this, 'defaultMachineName']],
      'description' => ['Theme description', 'A simple Drupal theme generated by DCG.'],
      'base_theme' => ['Base theme', NULL],
      'version' => ['Version', '7.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'];
    $this->files[$prefix . '.info'] = $this->render('d7/theme-info.twig', $vars);

  }

}
