<?php

function humanize_date(Carbon\Carbon $date, $format = 'd F Y, H:i') {
    return $date->format($format);
}
