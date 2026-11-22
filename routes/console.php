<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:clean')->dailyAt('01:00');
Schedule::command('backup:run')->dailyAt('02:00');
Schedule::command('telescope:prune')->dailyAt('03:00');
