<?php

namespace Drupal\events_management\DTO;

class EventDTO extends DataTransferObject
{
  public string $title;

  public mixed $description;
  public string $start_time;

  public string $end_time;

  public string $category;

  public array $image;

  public static function fromRequest(array $request): DataTransferObject
  {
    return new self([
      'title' => $request['title'],
      'description' => json_encode($request['description']),
      'start_time' => $request['start_time']->format('Y-m-d H:i:s'),
      'end_time' => $request['end_time']->format('Y-m-d H:i:s'),
      'category' => $request['category'],
      'image' => $request['image']
    ]);
  }
}
