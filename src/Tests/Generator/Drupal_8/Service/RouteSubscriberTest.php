<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:service:route-subscriber command.
 */
class RouteSubscriberTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Service\RouteSubscriber';

  protected $answers = [
    'Foo',
    'foo',
    TRUE,
  ];

  protected $fixtures = [
    'src/EventSubscriber/FooRouteSubscriber.php' => __DIR__ . '/_route_subscriber.php',
    'tests.services.yml' => __DIR__ . '/_route_subscriber.services.yml',
  ];

}
