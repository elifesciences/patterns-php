<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\EmailCta;

final class EmailCtaTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'headerText' => 'header text',
            'button' => [
                'classes' => 'button--default email-cta__button',
                'path' => '/the/button/path',
                'text' => 'the button text',
            ],
            'privacyUrl' => 'http://privacy-example.com',
            'privacyLabel' => 'Privacy notice',
        ];
        $emailCta = new EmailCta(
            'header text',
            Button::link('the button text', '/the/button/path'),
            'http://privacy-example.com',
            'Privacy notice'
        );

        $this->assertSame($data['headerText'], $emailCta['headerText']);
        $this->assertSame($data['button'], $emailCta['button']->toArray());
        $this->assertSame($data['privacyUrl'], $emailCta['privacyUrl']);
        $this->assertSame($data['privacyLabel'], $emailCta['privacyLabel']);
        $this->assertSameWithoutOrder($data, $emailCta->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            [
                new EmailCta(
                    'header text',
                    Button::link('the button text', '/the/button/path'),
                    'http://privacy-example.com',
                    'Privacy notice'
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/email-cta.mustache';
    }
}
