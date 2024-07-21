<?php

declare(strict_types=1);

namespace  Drupal\events_management\DTO;

use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{

  public function __construct(array $parameters)
  {
    $class = new ReflectionClass(static::class);
    foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
      $property = $reflectionProperty->getName();
      $this->{$property} = $parameters[$property];
    }
  }

  abstract public static function fromRequest(array $request): self;
}
