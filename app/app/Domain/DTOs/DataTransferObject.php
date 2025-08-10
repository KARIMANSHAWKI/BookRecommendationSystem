<?php

namespace App\Domain\DTOs;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{
    /**
     * @param  array<string,mixed>  $parameters
     */
    public function __construct(array|Model $parameters)
    {
        $class = new ReflectionClass(static::class);
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            $this->{$property} = $parameters[$property];
        }
    }

    /***
     * @param array<int, string> $request
     * @return static
     */
    abstract public static function fromRequest(array $request): self;
}
