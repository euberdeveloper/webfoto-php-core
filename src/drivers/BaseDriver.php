<?php

namespace Webfoto\Core\Drivers;

use DateTime;
use wherw\ScanPath;
use Webmozart\PathUtil\Path;

use Webfoto\Core\Types\InputImage;
use Webfoto\Core\Utils\Logger;

abstract class BaseDriver
{

    protected string $albumPath;

    private function extractImagesFromFolder(): array
    {
        $scan = new ScanPath();
        $scan->setPath($this->albumPath);
        $scan->setExtension(['jpg']);

        return $scan->getFiles()->toArray();
    }

    private function getFileName(string $path): string
    {
        return Path::getFileName($path);
    }

    protected abstract function extractDate(string $filename): DateTime;

    private function parseImage(string $path, callable $extractDate): InputImage
    {
        $filename = $this->getFileName($path);
        $timestamp = $extractDate($filename);
        return new InputImage($path, $timestamp);
    }

    protected function analyzeAlbumHelper(callable $extractDate): array
    {
        $rawFiles = $this->extractImagesFromFolder();
        $result =  array_map(fn ($path) => $this->parseImage($path, $extractDate), $rawFiles);
        usort($result, fn ($x, $y) => $x->timestamp->getTimestamp() - $y->timestamp->getTimestamp());
        return $result;
    }

    public abstract function analyzeAlbum(): array;

    function __construct(string $albumPath)
    {
        $this->albumPath = $albumPath;
        Logger::$logger->debug('Created driver with path', [$albumPath]);
    }
}
