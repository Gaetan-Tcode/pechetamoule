<?php

namespace App\Service;

use DateTime;

class DateTimeFormatter {

    public function format($date) {
        $dateString = '2023-03-16 15:30:00';
        $format = 'Y-m-d H:i:s';
        return DateTime::createFromFormat($format, $dateString);
    }

}