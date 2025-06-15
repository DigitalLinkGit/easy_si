<?php
// src/Capture/Rendering/FormCaptureRenderer.php
namespace App\Capture\Entity;

use App\Capture\Entity\FormCapture;
use App\Capture\Entity\FormField;
use App\Capture\Interface\RenderableInterface;

class FormCaptureRenderer implements RenderableInterface
{
    public function __construct(private FormCapture $formCapture)
    {
    }

    public function render(array $context): string
    {
        $output = '';

        if ($this->formCapture->getRenderTitle()) {
            $level = $this->formCapture->getRenderTitleLevel() ?? 1;
            $output .= str_repeat('#', $level) . ' ' . $this->formCapture->getRenderTitle() . "\n\n";
        }

        $template = $this->formCapture->getRenderTemplate() ?? '';

        foreach ($this->formCapture->getFields() as $field) {
            $name = $field->getName();
            $value = $context[$name] ?? '[' . $name . ']';
            $template = str_replace('[' . $name . ']', $value, $template);
        }

        $output .= $template;

        return $output;
    }
}
