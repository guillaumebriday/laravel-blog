<?php

namespace Tests\Unit;

use Tests\TestCase;
use Carbon\Carbon;

class DateHelperTest extends TestCase
{
    /**
     * it checks if the format returned is the default one
     * @return void
     */
    public function testHumanizeDate()
    {
        $date = Carbon::now();

        $this->assertEquals($date->format('d F Y, H:i'), humanize_date($date));
    }

    /**
     * it checks if the format returned is the specified one
     * @return void
     */
    public function testHumanizeDateFormat()
    {
        $date = Carbon::now();
        $format = 'Y-m-d H:i:s';

        $this->assertEquals($date->format($format), humanize_date($date, $format));
    }
}
