<?php

use Carbon\Carbon;

class DateHelperTest extends TestCase
{
    public function testHumanizeDate()
    {
        $date = Carbon::now();

        $this->assertEquals($date->format('d F Y, H:i'), humanize_date($date));
    }

    public function testHumanizeDateFormat()
    {
        $date = Carbon::now();
        $format = 'Y-m-d H:i:s';

        $this->assertEquals($date->format($format), humanize_date($date, $format));
    }
}
