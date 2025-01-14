<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Theme;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:theme:standard command.
 *
 * @TODO: Create a test for this.
 */
class Standard extends BaseGenerator {

  protected $name = 'd8:theme:standard';
  protected $description = 'Generates standard Drupal 8 theme';
  protected $alias = 'theme';

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

    $vars['project_type'] = 'theme';

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];
    $this->files[$prefix . '.info.yml'] = $this->render('d8/theme-info.yml.twig', $vars);
    $this->files[$prefix . '.libraries.yml'] = $this->render('d8/libraries.yml.twig', $vars);
    $this->files[$prefix . '.theme'] = $this->render('d8/theme.twig', $vars);
    $this->files[$vars['machine_name'] . '/js/' . $vars['machine_name'] . '.js'] = $this->render('d8/javascript.twig', $vars);
    $this->files[$vars['machine_name'] . '/templates'] = NULL;
    $this->files[$vars['machine_name'] . '/images'] = NULL;
    $this->files[$vars['machine_name'] . '/css/base/elements.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/block.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/breadcrumb.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/field.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/form.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/header.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/menu.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/messages.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/node.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/sidebar.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/table.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/tabs.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/buttons.css'] = '';
    $this->files[$vars['machine_name'] . '/css/layouts/layout.css'] = '';
    $this->files[$vars['machine_name'] . '/css/theme/print.css'] = '';

  }

}
