<?php

namespace App\Enum;

enum AssessmentSessionStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case VALIDATED = 'validated';
}