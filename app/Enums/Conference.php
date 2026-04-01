<?php

namespace App\Enums;

enum Conference: string
{
    case WEST = 'west';
    case EAST = 'east';

    public static function fromDivision(Division $division): self
    {
        return match ($division) {
            Division::ATLANTIC_DIVISION, Division::CENTRAL_DIVISION, Division::SOUTHEAST_DIVISION => self::EAST,
            Division::NORTHWEST_DIVISION, Division::PACIFIC_DIVISION, Division::SOUTHWEST_DIVISION => self::WEST,
            default => self::EAST,
        };
    }
}
