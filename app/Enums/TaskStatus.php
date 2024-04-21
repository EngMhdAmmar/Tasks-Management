<?php

namespace App\Enums;

enum TaskStatus: int
{
    case To_Do = 0;
    case In_Progress = 1;
    case Done = 2;

    public static function matchEnum($value): self
    {
        return match ($value) {
            0, '0' => self::To_Do,
            1, '1' => self::In_Progress,
            2, '2' => self::Done,
        };
    }
}
