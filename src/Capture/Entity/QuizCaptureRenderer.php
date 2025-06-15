<?php
// src/Capture/Rendering/FormCaptureRenderer.php
namespace App\Capture\Entity;


use App\Capture\Interface\RenderableInterface;

class QuizCaptureRenderer implements RenderableInterface
{
    public function __construct(private QuizCapture $quizCapture)
    {
    }

    public function render(array $context): string
    {
        $output = '';

        if ($this->quizCapture->getRenderTitle()) {
            $level = $this->quizCapture->getRenderTitleLevel() ?? 1;
            $output .= str_repeat('#', $level) . ' ' . $this->quizCapture->getRenderTitle() . "\n\n";
        }

        $template = $this->quizCapture->getRenderTemplate() ?? '';
        /*
        foreach ($this->quizCapture->getFields() as $field) {
            $name = $field->getName();
            $value = $context[$name] ?? '[' . $name . ']';
            $template = str_replace('[' . $name . ']', $value, $template);
        }
        */
        $output .= $template;

        return $output;
    }
}
