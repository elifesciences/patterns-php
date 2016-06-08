<?php

namespace eLife\Patterns;

interface ViewModel extends CastsToArray, HasAssets
{
    public function getTemplateName() : string;
}
