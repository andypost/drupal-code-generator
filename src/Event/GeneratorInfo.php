<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Event;

use Symfony\Component\Console\Command\Command;

/**
 * Fired when registering generators.
 */
final class GeneratorInfo {

  use StoppableEventTrait;

  private array $generators = [];

  /**
   * Constructs the generator info object.
   *
   * The generators are passed by reference as there are no getters for them.
   * That isolates data from listeners.
   */
  public function __construct(array &$generators) {
    $this->generators = &$generators;
  }

  /**
   * Adds generators.
   */
  public function addGenerators(Command ...$generators): void {
    $this->generators = \array_merge($this->generators, $generators);
  }

}
