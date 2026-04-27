<?php

namespace App\Enums;

enum serviceStatus: int
{
    use EnumHelper;

    case INACTIVE = 0;
    case ACTIVE = 1;
    case PENDING = 2;
    case APPROVED = 3;
    case REJECTED = 4;

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'Inactive',
            self::ACTIVE => 'Active',
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }
}
