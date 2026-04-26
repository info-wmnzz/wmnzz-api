<?php

namespace App\Enums;

enum ProductStatus: int
{
    use EnumHelper;

    case INACTIVE = 0;
    case ACTIVE = 1;
    case PENDING = 2;
    case APPROVED = 3;
    case REJECTED = 4;
}
