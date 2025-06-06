<?php

namespace App\Capture\Enum;

enum AnswerType: string
{
    case TEXT = 'text';                 // Champ texte libre
    case NUMBER = 'number';             // Champ numérique
    case DATE = 'date';                 // Date simple
    case BOOLEAN = 'boolean';           // Oui / Non
    case SINGLE_CHOICE = 'single_choice'; // Choix unique (radio)
    case MULTI_CHOICE = 'multi_choice';   // Choix multiple (checkbox)
}
