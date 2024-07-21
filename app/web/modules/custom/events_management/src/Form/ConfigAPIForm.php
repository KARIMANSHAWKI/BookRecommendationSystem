<?php

namespace Drupal\events_management\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\events_management\DTO\EventConfigLogDTO;
use Drupal\events_management\Services\BaseDB;
use Drupal\events_management\DTO\EventDTO;
use Exception;

class ConfigAPIForm extends FormBase
{

  public function getFormId(): string
  {
    return 'event_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $config = $this->config('events_management.settings');
    return [
      'show_past_events' => [
        '#type' => 'checkbox',
        '#title' => $this->t('Show past events'),
        '#default_value' => $config->get('show_past_events'),
      ],
      'events_per_page' => [
        '#type' => 'number',
        '#title' => $this->t('Number of events per page'),
        '#default_value' => $config->get('events_per_page'),
      ],
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Save'),
        '#buttonType' => 'primary'
      ]
    ];
  }

  /**
   * @throws Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    (new BaseDB())->create('events_management_log', (array)EventConfigLogDTO::fromRequest($form_state->getValues()));
    \Drupal::cache()->delete('event-config-cache');
    $this->messenger()->addMessage($this->t('Event Config Api Updated Successfully.'));
    $form_state->setRedirect('events_management.list');

  }

}
