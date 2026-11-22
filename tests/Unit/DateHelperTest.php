<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DateHelperTest extends TestCase
{
    use RefreshDatabase;

    public function test_humanize_date()
    {
        $date = now();

        $this->assertEquals($date->format('d F Y, H:i'), humanize_date($date));
    }

    public function test_humanize_date_format()
    {
        $date = now();
        $format = 'Y-m-d H:i:s';

        $this->assertEquals($date->format($format), humanize_date($date, $format));
    }
}
