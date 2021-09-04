<?php

namespace Webfoto\Core\Types;

use DateTime;

class Image
{
    public string $name;
    public string $path;
    public DateTime $timestamp;

    public function __construct(string $name, string $path, DateTime $timestamp)
    {
        $this->name = $name;
        $this->path = $path;
        $this->timestamp = $timestamp;
    }
}
