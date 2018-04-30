<?php

use Carbon\Carbon;

/**
 * Return a formatted Carbon date.
 */
function humanize_date(Carbon $date, string $format = 'd F Y, H:i'): string
{
    return $date->format($format);
}
