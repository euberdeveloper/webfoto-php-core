<?php

namespace Webfoto\Core\Drivers;

use DateTime;
use Webfoto\Core\Drivers\BaseDriver;

class DahuaDriver extends BaseDriver
{
    protected function extractDate(string $filename): DateTime
    {
        $datePart = explode('[', $filename)[0];

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
        return $this->analyzeAlbumHelper(fn ($filename) => $this->extractDate($filename));
    }
}
