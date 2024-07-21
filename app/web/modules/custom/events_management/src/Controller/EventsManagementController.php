<?php

namespace Drupal\events_management\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\events_management\Services\BaseDB;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EventsManagementController extends ControllerBase
{
  const IN_ACTIVE = 0;

  public function listEvents(): array
  {
    $showPastEvents = true;
    $eventConfig = $this->getEventConfig();
    $limit = $eventConfig->events_per_page;
    if ($eventConfig->show_past_events == self::IN_ACTIVE){
       $showPastEvents = false;
    }


    $events = (new BaseDB())->listEvents(limit: $limit, tableName: 'events', pastEvents: $showPastEvents);

    return [
      '#theme' => 'events_listing',
      '#events' => $events,
    ];
  }

  public function deleteEvent($nid): RedirectResponse
  {
    (new BaseDB())->delete('events', $nid);
    $this->messenger()->addMessage($this->t('Event Deleted successfully.'));
    return new RedirectResponse(Url::fromRoute('events_management.list')->toString());
  }

  public function showEvent($nid): array
  {
    $event = (new BaseDB())->findById('events', $nid);

    return [
      '#theme' => 'event_details',
      '#events' => $event,
    ];

  }


  private function getEventConfig(): object|bool|array
  {
    $config = Drupal::cache()->get('event-config-cache');

    if (!$config) {
      $config = (new BaseDB())->listAllRecords(tableName: 'events_management_log', orderByColumn: 'updated_at');
      Drupal::cache()->set('event-config-cache', $config[0]);
    }

    return $config;

  }

}
