<?php

namespace App\Service;

use DateTime;

class DateTimeFormatter {

    public function format($date, $hour) {
        $format = 'Ymd H:i';
        return DateTime::createFromFormat($format, $date . str_replace('h', ':', $hour));
    }

}