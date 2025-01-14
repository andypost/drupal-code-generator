<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\CToolsPlugin;

/**
 * Implements d7:ctools-plugin:relationship command.
 */
class Relationship extends BasePlugin {

  protected $name = 'd7:ctools-plugin:relationship';
  protected $description = 'Generates CTools relationship plugin';
  protected $template = 'd7/ctools-relationship-plugin.twig';

}
