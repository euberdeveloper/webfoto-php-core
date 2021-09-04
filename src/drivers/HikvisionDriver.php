<?php

namespace Webfoto\Core\Drivers;

use DateTime;
use Webfoto\Core\Drivers\BaseDriver;
use Webfoto\Core\Utils\Logger;

class HikvisionDriver extends BaseDriver
{
    protected function extractDate(string $filename): DateTime
    {
        $datePart = substr(explode('_TIMING', explode('.', $filename)[3])[0], 6);

        $year = substr($datePart, 0, 4);
        $month = substr($datePart, 4, 2);
        $date = substr($datePart, 6, 2);
        $hours = substr($datePart, 8, 2);
        $minutes = substr($datePart, 10, 2);
        $seconds = substr($datePart, 12, 2);

        $timestamp = strtotime("{$year}-{$month}-{$date} {$hours}:{$minutes}:{$seconds} UTC");
        return new DateTime("@{$timestamp}");
    }

    public function analyzeAlbum(): array
    {
        Logger::$logger->debug('Analyzing album', [$this->albumPath]);
        return $this->analyzeAlbumHelper(fn ($filename) => $this->extractDate($filename));
    }
}
