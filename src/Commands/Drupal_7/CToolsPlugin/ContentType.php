<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\CToolsPlugin;

/**
 * Implements d7:ctools-plugin:content-type command.
 */
class ContentType extends BasePlugin {

  protected $name = 'd7:ctools-plugin:content-type';
  protected $description = 'Generates CTools content type plugin';
  protected $template = 'd7/ctools-content-type-plugin.twig';

}
