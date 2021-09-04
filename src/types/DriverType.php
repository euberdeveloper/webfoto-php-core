<?php

namespace Webfoto\Core\Types;

use MyCLabs\Enum\Enum;

final class DriverType extends Enum
{
    private const DAHUA = 'dahua';
    private const HIKVISION = 'hikvision';
}