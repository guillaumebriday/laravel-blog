<?php

test('humanize date', function (): void {
    $date = now();

    expect(humanize_date($date))->toEqual($date->format('d F Y, H:i'));
});

test('humanize date format', function (): void {
    $date = now();
    $format = 'Y-m-d H:i:s';

    expect(humanize_date($date, $format))->toEqual($date->format($format));
});
