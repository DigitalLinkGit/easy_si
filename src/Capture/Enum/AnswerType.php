<?php

namespace App\Capture\Enum;

enum AnswerType: string
{
    case TEXT = 'textarea';                
    case NUMBER = 'number';            
    case DATE = 'date';                 
    case BOOLEAN = 'boolean';         
    case SINGLE_CHOICE = 'single_choice'; 
    case MULTI_CHOICE = 'multi_choice';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Texte',
            self::NUMBER => 'Nombre',
            self::DATE => 'Date',
            self::BOOLEAN => 'Oui/Non',
            self::SINGLE_CHOICE => 'Réponse à choix unique',
            self::MULTI_CHOICE => 'Réponse à choix multiple',
        };
    }
}
