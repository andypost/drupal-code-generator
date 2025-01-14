<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:yml:theme-info command.
 */
class ThemeInfo extends BaseGenerator {

  protected $name = 'd8:yml:theme-info';
  protected $description = 'Generates a theme info yml file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Theme name', [$this, 'defaultName']],
      'machine_name' => ['Theme machine name', [$this, 'defaultMachineName']],
      'base_theme' => ['Base theme', 'classy'],
      'description' => ['Description', 'A flexible theme with a responsive, mobile-first layout.'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.info.yml'] = $this->render('d8/theme-info.yml.twig', $vars);
  }

}
