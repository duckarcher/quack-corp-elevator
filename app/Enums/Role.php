<?php

namespace App\Enums;

use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;

enum Role: int
{
    case GOOSE = 1;
    case DUCK = 2;
    case QUACKTASTIC_RESEARCHERS = 3;
    case QUACKCONOMICS_OFFICERS = 4;
    case QUACKTELLIGENCE_OPERATIVES = 5;
    case QUACKTATOR = 6;
    case C_LEVEL = 7;

    public static function allRolesExcept($roles = [])
    {
        return Arr::except(
            Arr::keyBy(Role::cases(), 'value'),
            Arr::pluck($roles, 'value')
        );
    }

    public function restrictedFloors()
    {
        return match($this)
        {
            Role::GOOSE => [-2, -1, 1, 2, 3, 4, 5, 6, 7],
            Role::DUCK => [-2, 2, 3, 4, 6, 7],
            Role::QUACKTASTIC_RESEARCHERS => [3, 4, 5, 6, 7],
            default => [],
        };
    }

    public function allowedFloors()
    {
        return match($this)
        {
            Role::GOOSE => [-3, 0],
            Role::DUCK => [-3, -1, 0, 1, 5],
            Role::QUACKTASTIC_RESEARCHERS => [-3, -2, 0, 1, 2],
            default => [],
        };
    }
}
