<?php

function humanize_date(Carbon\Carbon $date) {
    return $date->format('d F Y, H:i');
}
