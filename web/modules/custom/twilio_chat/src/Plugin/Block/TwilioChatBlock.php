<?php

namespace Drupal\twilio_chat\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Provides a 'TwilioChatBlock' block.
 *
 * @Block(
 *  id = "twilio_chat_block",
 *  admin_label = @Translation("Twilio chat block"),
 * )
 */
class TwilioChatBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;
  /**
   * Constructs a new TwilioChatBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    ConfigFactory $config_factory
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
//    $build['twilio_chat_block']['#markup'] = 'Implement TwilioChatBlock.';
    $build['twilio_chat_block']['#theme'] = 'twilio_chat';
    $build['twilio_chat_block']['#attached']['library'] = 'twilio_chat/chat-block';
    return $build;
  }

}
