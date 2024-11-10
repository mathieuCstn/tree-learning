<?php

namespace App\Enum;

enum CourseMode: string
{
    case ONSITE = 'onsite';         // Présentiel
    case REMOTE = 'remote';         // Distanciel
    case HYBRID = 'hybrid';         // Hybride (combinaison de présentiel et distanciel)
}
