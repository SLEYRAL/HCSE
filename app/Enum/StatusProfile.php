<?php


namespace App\Enum;

enum StatusProfile: string
{
    case Active = 'actif';
    case Inactive = 'inactif';
    case Waiting = 'en attente';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }
        return $array;
    }
}
