<?php

namespace App\Orders\Domain\Service;

class DateTimeService
{
    public static function generate(): string
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('GMT+2'));
        $date->modify('+3 minutes');

        return $date->format('Y-m-d H:i:s');
    }
}
