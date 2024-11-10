<?php

namespace App\Enum;

enum DegreeLevel: string
{
    case NONE = 'None';                     // Pas de diplôme
    case HIGH_SCHOOL = 'High School Diploma';
    case ASSOCIATE = 'Associate Degree';     // e.g., AA, AS
    case BACHELOR = 'Bachelor';              // e.g., BA, BS, BEng
    case MASTER = 'Master';                  // e.g., MA, MS, MBA
    case DOCTORATE = 'Doctorate';            // e.g., PhD, EdD
    case CERTIFICATE = 'Certificate';        // e.g., Professional Certification
    case DIPLOMA = 'Diploma';                // e.g., Advanced Diploma
    case PROFESSIONAL = 'Professional Degree'; // e.g., JD, PharmD
}
