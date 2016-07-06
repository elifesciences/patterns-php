<?php

namespace eLife\Patterns;

trait MultipleTemplates
{
    private $templateName;

    abstract public function getDefaultTemplateName() : string;

    public function setTemplateName(string $templateName)
    {
        $this->templateName = $templateName;

        return $this;
    }

    public function getTemplateName() : string
    {
        if ($this->templateName) {
            return '/elife/patterns/templates/'.$this->templateName.'.mustache';
        } else {
            return $this->getDefaultTemplateName();
        }
    }
}
