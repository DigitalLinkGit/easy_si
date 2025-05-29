<?php
// src/Form/DataTransformer/JsonToArrayTransformer.php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class JsonToArrayTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): string
    {
        return $value ? json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '';
    }

    public function reverseTransform(mixed $value): ?array
    {
        if (!$value) return null;

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \UnexpectedValueException('JSON invalide');
        }

        return $decoded;
    }
}
