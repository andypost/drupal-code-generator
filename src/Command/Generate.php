<?php

namespace DrupalCodeGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class Generate extends Command {

  protected $menuTree = [];
  protected $activeMenuItems = [];

  protected function configure() {
    $this
      ->setName('generate')
      ->setDescription('Generate code');

    $this->menuTree = [
      'Drupal 8' => [
        'Module' => NULL,
        'Theme' => NULL,
        'Installation profile' => NULL,
        'Component' => [
          'Plugin' => [
            'Filter' => NULL,
            'FieldType' => NULL,
            'Block' => NULL,
          ],
          'YML file' => [
            'libraries.yml',
            'routing.yml',
            'services.yml'
          ]
        ],
      ],
      'Drupal 7' => [
        'Module' => NULL,
        'Theme' => NULL,
        'Installation profile' => NULL,
        'Component' => [
          'settings.php file' => NULL,
          'Info file' => NULL,
          'Module file' => NULL,
          'Javascript' => NULL,
        ],
      ],
      'Drupal 6' => [
        'Module' => NULL,
        'Theme' => NULL,
        'Installation profile' => NULL,
        'Component' => [
          'Info file' => NULL,
          'Module file' => NULL,
          'Javascript' => NULL,
          'Ctools plugin' => [],
        ],
      ],
      'Drush' => [
        'Command' => NULL,
      ]
    ];

  }

  /**
   *
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $style = new OutputFormatterStyle('black', 'cyan', []);
    $output->getFormatter()->setStyle('title', $style);

    /** @var \DrupalCodeGenerator\Command\BaseGenerator $generator */
    $generator = $this->selectGenerator($input, $output);

    try {
      $command = $this->getApplication()->find($generator);
    }
    catch(\InvalidArgumentException $e) {
      $output->writeLn("<error>Sorry generator $generator is not implemented yet.</error>");
      exit(1);
    }

    $output->writeln(sprintf('<info>Command:</info> <comment>%s</comment>', $command->getName()));
    $output->writeLn(str_repeat('<comment>-</comment>', 35));

    $command->run($input, $output);
  }

  /**
   *
   */
  protected function selectGenerator(InputInterface $input, OutputInterface $output) {

    $tree = $this->menuTree;
    foreach ($this->activeMenuItems as $menuItem) {
      $tree = $tree[$menuItem];
    }
    $menu = is_array($tree) ? array_keys($tree) : NULL;

    if (is_array($menu)) {

      array_unshift($menu, '..');

      if (!$this->activeMenuItems) {
        unset($menu[0]);
      }

      $helper = $this->getHelper('question');
      $question = new ChoiceQuestion(
        '<title>Select generator:</title>',
        $menu
      );

      $answer = $helper->ask($input, $output, $question);

      if ($answer == '..') {
        array_pop($this->activeMenuItems);
      }
      else {
        $this->activeMenuItems[] = $answer;
      }

      return $this->selectGenerator($input, $output);
    }
    else {
      $generator = implode(':',$this->activeMenuItems);
      $generator = strtolower($generator);
      $generator = str_replace('drupal ', 'd', $generator);
      $generator = str_replace(' ', '_', $generator);
      return 'generate:' . $generator;
    }

  }

}
