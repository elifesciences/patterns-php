<?php

namespace eLife\Patterns\PatternRenderer;

use ArrayObject;
use eLife\Patterns\HasAssets;
use eLife\Patterns\PatternRenderer;
use eLife\Patterns\ViewModel;
use Traversable;

final class AssetRecordingPatternRenderer implements PatternRenderer, HasAssets
{
    private $patternRenderer;
    private $javaScripts;

    public function __construct(PatternRenderer $patternRenderer)
    {
        $this->patternRenderer = $patternRenderer;
        $this->javaScripts = new ArrayObject();
    }

    public function render(ViewModel ...$viewModels) : string
    {
        foreach ($viewModels as $viewModel) {
            foreach ($viewModel->getJavaScripts() as $javaScript) {
                if (false !== $this->contains($this->javaScripts, $javaScript)) {
                    continue;
                }
                $this->javaScripts[] = $javaScript;
            }
        }

        return $this->patternRenderer->render(...$viewModels);
    }

    public function getJavaScripts() : Traversable
    {
        return $this->javaScripts;
    }

    private function contains(ArrayObject $array, $item, bool $strict = false) : bool
    {
        return false !== array_search($item, $array->getArrayCopy(), $strict);
    }
}
