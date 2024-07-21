<?php

namespace Drupal\events_management\Form;

use DateTime;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\events_management\DTO\EventDTO;
use Drupal\events_management\Services\BaseDB;
use Exception;

class EventUpdateForm extends FormBase
{

  public function getFormId(): string
  {
    return 'event_update_form';
  }

  /**
   * @throws Exception
   */
  public function buildForm(array $form, FormStateInterface $form_state, $nid = NULL): array
  {
    $event =  (new BaseDB())->findById('events', $nid);

    return [
      'id' => [
        '#type' => 'hidden',
        '#title' => $this->t('ID'),
        '#required' => TRUE,
        '#default_value' => $event->id
      ],
      'title' => [
        '#type' => 'textfield',
        '#title' => $this->t('Title'),
        '#required' => TRUE,
        '#default_value' => $event->title
      ],
      'description' => [
        '#type' => 'text_format',
        '#title' => $this->t('Description'),
        '#required' => TRUE,
        '#default_value' => $event->description
      ],
      'start_time' => [
        '#type' => 'datetime',
        '#title' => $this->t('Start Date'),
        '#required' => TRUE,
        '#default_value' => new DateTime($event->start_time)
      ],
      'end_time' => [
        '#type' => 'datetime',
        '#title' => $this->t('End Date'),
        '#required' => TRUE,
        '#default_value' => new DateTime($event->end_time)
      ],
      'image' => [
        '#type' => 'managed_file',
        '#title' => $this->t('Image'),
        '#upload_location' => 'public://events/',
        '#required' => FALSE,
        '#upload_validators' => [
          'file_validate_extensions' => ['png jpg jpeg'],
        ],
        '#default_value' => $event->image
      ],
      'category' => [
        '#type' => 'textfield',
        '#title' => $this->t('Category'),
        '#required' => TRUE,
        '#default_value' => $event->category
      ],
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Update Event'),
        '#buttonType' => 'primary'
      ]
    ];
  }

  /**
   * @throws Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $values = $form_state->getValues();
     (new BaseDB())->update('events', $values['id'], array_filter((array)EventDTO::fromRequest($values)));
    $this->messenger()->addMessage($this->t('Event Updated successfully.'));
    $form_state->setRedirect('events_management.list');
  }
}
