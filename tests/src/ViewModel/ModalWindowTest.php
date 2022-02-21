<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ModalWindow;

final class ModalWindowTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'Here is a title',
            'body' => 'Here is some text for the body section.',
            'closeBtnText' => 'Close',
        ];
        $modalWindow = ModalWindow::main('Here is a title', 'Here is some text for the body section.', 'Close');

        $this->assertSame($data['title'], $modalWindow['title']);
        $this->assertSame($data['body'], $modalWindow['body']);
        $this->assertSame($data['closeBtnText'], $modalWindow['closeBtnText']);
    }

    /**
     * @test
     */
    public function it_may_have_close_button_text()
    {
        $with = ModalWindow::main('title', 'body', 'closeBtnText');
        $without = ModalWindow::main('title', 'body');

        $this->assertArrayHasKey('closeBtnText', $with->toArray());

        $this->assertArrayNotHasKey('closeBtnText', $without->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_title()
    {
        $this->expectException(InvalidArgumentException::class);

        ModalWindow::main('', 'body', 'closeBtnText');
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_body()
    {
        $this->expectException(InvalidArgumentException::class);

        ModalWindow::main('title', '', 'closeBtnText');
    }

    public function viewModelProvider() : array
    {
        return [
            'main minimal' => [ModalWindow::main('title', 'body')],
            'main complete' => [ModalWindow::main('title', 'body', 'closeBtnText')],
            'small minimal' => [ModalWindow::small('title', 'body')],
            'small complete' => [ModalWindow::small('title', 'body', 'closeBtnText')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/modal-window.mustache';
    }
}
