<?php

namespace App\Enums;

use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;

enum Floor: int
{
    case MINUS_3 = -3;
    case MINUS_2 = -2;
    case MINUS_1 = -1;
    case GROUND = 0;
    case FIRST = 1;
    case SECOND = 2;
    case THIRD = 3;
    case FOURTH = 4;
    case FIFTH = 5;
    case SIXTH = 6;
    case SEVENTH = 7;

    public function allowedRoles()
    {
        return match($this)
        {
            Floor::MINUS_3 => Role::cases(),
            Floor::MINUS_2 => Role::QUACKTASTIC_RESEARCHERS,
            Floor::MINUS_1 => Role::QUACKTASTIC_RESEARCHERS,
            Floor::GROUND => Role::cases(),
            Floor::FIRST => Role::allRolesExcept([Role::GOOSE]),
            Floor::SECOND => Role::QUACKCONOMICS_OFFICERS,
            Floor::THIRD => [Role::QUACKTELLIGENCE_OPERATIVES, Role::C_LEVEL],
            Floor::FOURTH => [Role::QUACKTELLIGENCE_OPERATIVES, Role::QUACKTATOR],
            Floor::FIFTH => [Role::allRolesExcept([Role::GOOSE])],
            Floor::SIXTH => [Role::QUACKTELLIGENCE_OPERATIVES, Role::QUACKTATOR, Role::C_LEVEL],
            Floor::SEVENTH => [Role::C_LEVEL],
        };
    }
}
