<?php
namespace App\Controllers;

use App\Models\LeapYear;

class LeapYearController
{
    public function index(int $year): string
    {
        $leapYear = new LeapYear();
        if ($leapYear->isLeapYear($year)) {
            return 'Yep, this is a leap year! ';
        }

        return 'Nope, this is not a leap year.';
    }
}