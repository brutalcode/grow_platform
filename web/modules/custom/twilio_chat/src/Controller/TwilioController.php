<?php

namespace Drupal\twilio_chat\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

/**
 * Class TwilioController.
 */
class TwilioController extends ControllerBase {

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructs a new TwilioController object.
   */
  public function __construct(ConfigFactory $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * Token.
   *
   * @return string
   *   Return Hello string.
   */
  public function token() {
    $user_name = $this->currentUser()->getAccountName();
    $user_id = $this->currentUser()->id();
    $identity = $user_id;

    if ($this->currentUser()->isAnonymous()){
      $identity = $user_name = "anonymous";
    }
    $config = $this->configFactory->getEditable("twilio_chat.twiliosecurity");

    $token = new AccessToken(
      $config->get('twilio_account_sid'),
      $config->get('twilio_api_key'),
      $config->get('twilio_api_secret'),
      3600,
      $identity
    );

    $chatGrant = new ChatGrant();
    $chatGrant->setServiceSid($config->get('twilio_chat_service_sid'));
    $token->addGrant($chatGrant);

    $response = new JsonResponse();
    $response->setData([
      'identity' => $identity,
      'username' => $user_name,
      'token' => $token->toJWT(),
    ]);

    return $response;
  }

  // Generate a random username for the connecting client
  private function randomUsername() {
    $ADJECTIVES = array(
      'Abrasive', 'Brash', 'Callous', 'Daft', 'Eccentric', 'Fiesty', 'Golden',
      'Holy', 'Ignominious', 'Joltin', 'Killer', 'Luscious', 'Mushy', 'Nasty',
      'OldSchool', 'Pompous', 'Quiet', 'Rowdy', 'Sneaky', 'Tawdry',
      'Unique', 'Vivacious', 'Wicked', 'Xenophobic', 'Yawning', 'Zesty',
    );

    $FIRST_NAMES = array(
      'Anna', 'Bobby', 'Cameron', 'Danny', 'Emmett', 'Frida', 'Gracie', 'Hannah',
      'Isaac', 'Jenova', 'Kendra', 'Lando', 'Mufasa', 'Nate', 'Owen', 'Penny',
      'Quincy', 'Roddy', 'Samantha', 'Tammy', 'Ulysses', 'Victoria', 'Wendy',
      'Xander', 'Yolanda', 'Zelda',
    );

    $LAST_NAMES = array(
      'Anchorage', 'Berlin', 'Cucamonga', 'Davenport', 'Essex', 'Fresno',
      'Gunsight', 'Hanover', 'Indianapolis', 'Jamestown', 'Kane', 'Liberty',
      'Minneapolis', 'Nevis', 'Oakland', 'Portland', 'Quantico', 'Raleigh',
      'SaintPaul', 'Tulsa', 'Utica', 'Vail', 'Warsaw', 'XiaoJin', 'Yale',
      'Zimmerman',
    );

    // Choose random components of username and return it
    $adj = $ADJECTIVES[array_rand($ADJECTIVES)];
    $fn = $FIRST_NAMES[array_rand($FIRST_NAMES)];
    $ln = $LAST_NAMES[array_rand($LAST_NAMES)];

    return $adj . $fn . $ln;
  }
}
