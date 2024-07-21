<?php

namespace Drupal\events_management\DTO;

use DateTime;

class EventConfigLogDTO extends DataTransferObject
{
  public int $show_past_events;

  public int $events_per_page;

  public string $updated_at;

  public static function fromRequest(array $request): DataTransferObject
  {
    return new self([
      'show_past_events' => (int) $request['show_past_events'],
      'events_per_page' => (int) $request['events_per_page'],
      'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ]);
  }
}
