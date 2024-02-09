<?php

namespace App;

use Carbon\Carbon;

class Helpers
{
    public static function getMonthsList(): array
    {
        return array_map(fn($month) => Carbon::create(null, $month)->format('F'), range(1, 12));
    }

    public static function getRandomCity(): string
    {
        $array = ['Manizales', 'Pereira', 'Bogotá', 'Medellín', 'Cali'];
        return $array[array_rand($array)];
    }

}