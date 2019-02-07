<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\InfoBar;
use InvalidArgumentException;

final class InfoBarTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'text',
            'type' => InfoBar::TYPE_INFO,
        ];

        $infoBar = new InfoBar($data['text'], $data['type']);

        $this->assertSame($data['text'], $infoBar['text']);
        $this->assertSame($data['type'], $infoBar['type']);
        $this->assertSame($data, $infoBar->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new InfoBar('', InfoBar::TYPE_INFO);
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);

        new InfoBar('text', 'foo');
    }

    public function viewModelProvider() : array
    {
        return [
            'attention' => [new InfoBar('text', InfoBar::TYPE_ATTENTION)],
            'info' => [new InfoBar('text', InfoBar::TYPE_INFO)],
            'success' => [new InfoBar('text', InfoBar::TYPE_SUCCESS)],
            'correction' => [new InfoBar('text', InfoBar::TYPE_CORRECTION)],
            'warning' => [new InfoBar('text', InfoBar::TYPE_WARNING)],
            'multiple articles' => [new InfoBar('text', InfoBar::TYPE_MULTIPLE_VERSIONS)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/info-bar.mustache';
    }
}
