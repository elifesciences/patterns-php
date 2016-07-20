<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use InvalidArgumentException;
use Traversable;

final class LoadMoreButtonTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'classes' => 'button--small button--outline button--full',
            'path' => 'path',
            'text' => 'text',
            'templateName' => 'load-more',
        ];

        $button = Button::loadMoreLink('text', 'path', Button::SIZE_SMALL, Button::STYLE_OUTLINE, true, true);

        $this->assertSame($data['text'], $button['text']);
        $this->assertSame($data['path'], $button['path']);
        $this->assertSame($data['classes'], $button['classes']);
        $this->assertSame($data, $button->toArray());
    }

    /**
     * @test
     */
    public function it_has_correct_assets()
    {
        $button = Button::loadMoreLink('text', 'path', Button::SIZE_SMALL, Button::STYLE_OUTLINE, true, true);

        $sheets = [];
        foreach ($button->getStyleSheets() as $styleSheet) {
            $sheets[] = $styleSheet;
        }
        $this->assertSame([
            '/elife/patterns/assets/css/buttons.css',
            '/elife/patterns/assets/css/load-more.css',
        ], $sheets);

        $this->assertSame('/elife/patterns/templates/load-more.mustache', $button->getTemplateName());
    }

    /**
     * @test
     */
    public function it_merges_outline_and_inactive_states()
    {
        $button = Button::loadMoreLink('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_OUTLINE, false);

        $this->assertSame('button--outline-inactive', $button['classes']);
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::loadMoreLink('', 'path');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_path()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::loadMoreLink('text', '');
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_size()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::loadMoreLink('text', 'path', Button::TYPE_BUTTON, 'foo');
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_style()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::loadMoreLink('text', 'path', Button::TYPE_BUTTON, Button::SIZE_MEDIUM, 'foo');
    }

    public function viewModelProvider() : array
    {
        return [
            'button' => [Button::link('text', 'path')],
            'small' => [Button::loadMoreLink('text', 'path', Button::SIZE_SMALL)],
            'extra small' => [Button::loadMoreLink('text', 'path', Button::SIZE_SMALL)],
            'outline' => [Button::loadMoreLink('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_OUTLINE)],
            'inactive' => [Button::loadMoreLink('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, false)],
            'full width' => [
                Button::loadMoreLink('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, true, true),
            ],
        ];
    }

    protected function expectedStylesheets() : Traversable
    {
        yield '/elife/patterns/assets/css/buttons.css';
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/button.mustache';
    }
}
