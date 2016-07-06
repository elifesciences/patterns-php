<?php

namespace eLife\Patterns;

trait MultipleTemplates
{
    private $templateName;

    abstract function getDefaultTemplateName() : string;

    public function setTemplateName(string $templateName)
    {
        $this->templateName = $templateName;
        return $this;
    }

    public function getTemplateName() : string
    {
        if ($this->templateName) {
            return $this->templateName;
        } else {
            return $this->getDefaultTemplateName();
        }
    }
}
