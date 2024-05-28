<?php

namespace Organon\Delivery\Helpers;

use Organon\Delivery\Models\Package;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRGeneratorHelper
{
    private static function generate($content)
    {
        return QrCode::size(256)->generate($content);
    }

    public static function fromPackage(Package $package)
    {
        return self::generate($package->hash);
    }
}
