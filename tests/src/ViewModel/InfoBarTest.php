<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
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
            'type' => InfoBar::TYPE_DISMISSIBLE,
            'dismissible' => [
                'cookieDuration' => 3,
                'cookieExpires' => null,
            ],
        ];

        $infoBar = new InfoBar($data['text'], $data['type'], $data['dismissible']['cookieDuration']);

        $this->assertSame($data['text'], $infoBar['text']);
        $this->assertSame($data['type'], $infoBar['type']);
        $this->assertSame($data['dismissible'], $infoBar['dismissible']);
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
    public function dismissible_must_have_cookie_expires_or_cookie_duration() {
        $this->expectException(InvalidArgumentException::class);

        new InfoBar('some text', InfoBar::TYPE_DISMISSIBLE);
    }

    /**
     * @test
     */
    public function dismissible_must_not_have_both_cookie_expires_and_cookie_duration() {
        $this->expectException(InvalidArgumentException::class);

        new InfoBar('some text', InfoBar::TYPE_DISMISSIBLE, 3, new DateTimeImmutable('now'));
    }

    public function viewModelProvider() : array
    {
        return [
            'attention' => [new InfoBar('text', InfoBar::TYPE_ATTENTION)],
            'dismissible' => [new InfoBar('text', InfoBar::TYPE_DISMISSIBLE, 3)],
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
