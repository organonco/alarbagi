<?php

namespace Organon\Delivery\Helpers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRGeneratorHelper
{
    private static function generate($content)
    {
        return QrCode::size(256)->generate(json_encode($content));
    }

    public static function test()
    {
        return self::generate("TESTST");
    }
}
