<?php
// src/Capture/Rendering/RenderableInterface.php
namespace App\Capture\Interface;

interface RenderableInterface
{
    public function render(array $context): string;
}
