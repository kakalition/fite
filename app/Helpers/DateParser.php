<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;

class DateParser
{
  public static function parse($db_time, $timezone)
  {
    $unix_timestamp = strtotime($db_time);
    $dt = new DateTime();
    $dt->setTimestamp($unix_timestamp);
    $dt->setTimezone(new DateTimeZone($timezone));
    return $dt->format('F/d/Y - H:i');
  }
}
