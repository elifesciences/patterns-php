<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 10/06/2016
 * Time: 15:02
 */

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use LengthException;
use Traversable;

class TeaserNonArticleContent implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $content;
    private $date;
    private $headerText;
    private $link;

    public function __construct(string $content, Date $date,
                                string $headerText, string $link, $subHeader = null)
    {
        if ($content === 'dump') {
            var_dump(func_get_args());
        }

        if (strlen($headerText) === 0) {
            throw new LengthException('$headerText argument must not be an empty string');
        }
        if (strlen($link) === 0) {
            throw new LengthException('$link argument must not be an empty string');
        }
        if (strlen($content) === 0) {
            throw new LengthException('$content argument must not be an empty string');
        }
        if (gettype($subHeader) === 'string') {
            if (strlen($subHeader) === 0) {
                throw new LengthException('if supplied, the optional $subHeader argument must not be an empty string');
            }
        }
        $this->content = $content;
        $this->date = $date;
        $this->headerText = $headerText;
        $this->link = $link;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/teaser--non-article-content.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/teaser--non-article-content.mustache';
    }
}
