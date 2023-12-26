<?php

namespace Drupal\breezy_component_ui\Form;

use Drupal\breakpoint\BreakpointManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a configuration form for Breezy Components.
 */
class BreezyComponentsSettingsForm extends ConfigFormBase {

  /**
   * Drupal\breakpoint\BreakpointManagerInterface definition.
   *
   * @var \Drupal\breakpoint\BreakpointManagerInterface
   */
  protected $breakpointManager;

  /**
   * Constructs a new settings form object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\breakpoint\BreakpointManagerInterface $breakpoint_manager
   *   The breakpoint manager service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, BreakpointManagerInterface $breakpoint_manager) {
    parent::__construct($config_factory);
    $this->breakpointManager = $breakpoint_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    /** @var \Drupal\breakpoint\BreakpointManagerInterface $breakpoint_manager */
    $breakpoint_manager = $container->get('breakpoint.manager');
    /** @var \Drupal\Core\Config\ConfigFactoryInterface $config_factory */
    $config_factory = $container->get('config.factory');
    return new static($config_factory, $breakpoint_manager);
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'breezy_components_configuration';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['breezy_components.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('breezy_components.settings');

    $form['breakpoint_group'] = [
      '#type' => 'select',
      '#title' => $this->t('Breakpoint group'),
      '#default_value' => $config->get('breakpoint_group') ?? '',
      '#options' => $this->breakpointManager->getGroups(),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('breezy_components.settings');
    $config->set('breakpoint_group', $form_state->getValue('breakpoint_group'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
