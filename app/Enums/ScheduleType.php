<?php

namespace App\Enums;

enum ScheduleType: int
{
    case None = 0;
    case Daily = 1;
    case Weekly = 2;
    case Monthly = 3;

    public static function matchEnum($value): self
    {
        return match ($value) {
            0, '0' => self::None,
            1, '1' => self::Daily,
            2, '2' => self::Weekly,
            3, '3' => self::Monthly
        };
    }
}
