<?php

/**
 * @file
 * Contains \Drupal\foo\Plugin\Condition\Example.
 */

namespace Drupal\foo\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Example' condition.
 *
 * @Condition(
 *   id = "foo_example",
 *   label = @Translation("Example"),
 *   context = {
 *     "node" = @ContextDefinition(
 *       "entity:node",
 *        label = @Translation("Node")
 *      )
 *   }
 * )
 */
class Example extends ConditionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The date formatter.
   *
   * @var DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Creates a new Example instance.
   *
   * @param DateFormatterInterface $date_formatter
   *   The date formatter.
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(DateFormatterInterface $date_formatter, array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('date.formatter'),
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {

    $form['age'] = [
      '#title' => $this->t('Node age, sec'),
      '#type' => 'number',
      '#min' => 0,
      '#default_value' => $this->configuration['age'],
    ];

    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['age'] = $form_state->getValue('age');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t(
      'Node age: @age',
      ['@age' => $this->dateFormatter->formatInterval($this->configuration['age'])]
    );
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    if (!$age = $this->configuration['age']) {
      return !$this->isNegated();
    }

    return (REQUEST_TIME - $this->getContextValue('node')->getCreatedTime()) < $age;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['age' => NULL] + parent::defaultConfiguration();
  }

}
