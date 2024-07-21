<?php

namespace Drupal\events_management\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\events_management\Services\BaseDB;
use Drupal\events_management\DTO\EventDTO;
use Exception;

class EventCreateForm extends FormBase
{

  public function getFormId(): string
  {
    return 'event_create_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    return [
      'title' => [
        '#type' => 'textfield',
        '#title' => $this->t('Title'),
        '#required' => TRUE,
      ],
      'description' => [
        '#type' => 'text_format',
        '#title' => $this->t('Description'),
        '#required' => TRUE,
      ],
      'start_time' => [
        '#type' => 'datetime',
        '#title' => $this->t('Start Date'),
        '#required' => TRUE,
      ],
      'end_time' => [
        '#type' => 'datetime',
        '#title' => $this->t('End Date'),
        '#required' => TRUE,
      ],
      'image' => [
        '#type' => 'managed_file',
        '#title' => $this->t('Image'),
        '#upload_location' => 'public://events/',
        '#required' => FALSE,
        '#upload_validators' => [
          'file_validate_extensions' => ['png jpg jpeg'],
        ]
      ],
      'category' => [
        '#type' => 'textfield',
        '#title' => $this->t('Category'),
        '#required' => TRUE,
      ],
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Create Event'),
        '#buttonType' => 'primary'
      ]
    ];
  }

  /**
   * @throws Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    (new BaseDB())->create('events', (array)EventDTO::fromRequest($form_state->getValues()));
    $this->messenger()->addMessage($this->t('Event Created successfully.'));
    $form_state->setRedirect('events_management.list');
  }

}
