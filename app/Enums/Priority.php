<?php

namespace App\Enums;

enum Priority: int
{
    case To_Do_Last = 0;
    case Normal = 1;
    case Important = 2;

    public static function matchEnum($value): self
    {
        return match ($value) {
            0, '0' => self::To_Do_Last,
            1, '1' => self::Normal,
            2, '2' => self::Important,
        };
    }
}
