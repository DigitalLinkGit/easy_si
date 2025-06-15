<?php
// src/Capture/Enum/CaptureElementType.php
namespace App\Capture\Enum;

enum CaptureElementTypeEnum: string
{
    case QUIZ = 'quiz';
    case FORM = 'form';
    case PARTICIPANT = 'participant';

    public function label(): string
    {
        return match ($this) {
            self::QUIZ => 'Questionnaire',
            self::FORM => 'Formulaire',
            self::PARTICIPANT => 'Participants',
        };
    }
}
