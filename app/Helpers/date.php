<?php

/**
 * Return a formatted Carbon date.
 *
 * @param  Carbon\Carbon $date
 * @param  string $format
 * @return string
 */
function humanize_date(Carbon\Carbon $date, $format = 'd F Y, H:i'): string
{
    return $date->format($format);
}
