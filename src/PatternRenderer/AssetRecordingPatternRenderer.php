<?php

namespace eLife\Patterns\PatternRenderer;

use ArrayObject;
use eLife\Patterns\HasAssets;
use eLife\Patterns\PatternRenderer;
use eLife\Patterns\ViewModel;
use Traversable;
use function eLife\Patterns\sanitise_traversable;

final class AssetRecordingPatternRenderer implements PatternRenderer, HasAssets
{
    private $patternRenderer;
    private $styleSheets;
    private $javaScripts;

    public function __construct(PatternRenderer $patternRenderer)
    {
        $this->patternRenderer = $patternRenderer;
        $this->styleSheets = new ArrayObject();
        $this->javaScripts = new ArrayObject();
    }

    public function render(ViewModel $viewModel) : string
    {
        foreach (sanitise_traversable($viewModel->getStyleSheets()) as $styleSheet) {
            if (false !== $this->contains($this->styleSheets, $styleSheet)) {
                continue;
            }
            $this->styleSheets[] = $styleSheet;
        };

        foreach (sanitise_traversable($viewModel->getJavaScripts()) as $javaScript) {
            if (false !== $this->contains($this->javaScripts, $javaScript)) {
                continue;
            }
            $this->javaScripts[] = $javaScript;
        };

        return $this->patternRenderer->render($viewModel);
    }

    public function getStyleSheets() : Traversable
    {
        return $this->styleSheets;
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
