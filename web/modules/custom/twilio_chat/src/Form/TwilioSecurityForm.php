<?php

namespace Drupal\twilio_chat\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TwilioSecurityForm.
 */
class TwilioSecurityForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'twilio_chat.twiliosecurity',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'twilio_security_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('twilio_chat.twiliosecurity');
    $form['twilio_account_sid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twilio account SID'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('twilio_account_sid'),
    ];
    $form['twilio_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twilio API key'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('twilio_api_key'),
    ];
    $form['twilio_api_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twilio API secret'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('twilio_api_secret'),
    ];
    $form['twilio_chat_service_sid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twilio chat service SID'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('twilio_chat_service_sid'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('twilio_chat.twiliosecurity')
      ->set('twilio_account_sid', $form_state->getValue('twilio_account_sid'))
      ->set('twilio_api_key', $form_state->getValue('twilio_api_key'))
      ->set('twilio_api_secret', $form_state->getValue('twilio_api_secret'))
      ->set('twilio_chat_service_sid', $form_state->getValue('twilio_chat_service_sid'))
      ->save();
  }

}
