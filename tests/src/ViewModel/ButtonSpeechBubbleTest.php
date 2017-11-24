<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;

final class ButtonSpeechBubbleTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'type' => 'button',
            'text' => '<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations</span>',
            'name' => 'theName',
            'id' => 'theId',
        ];

        $buttonSpeechBubble = Button::speechBubble($data['text'], $data['name'], $data['id']);
        $this->assertSameWithoutOrder($data, $buttonSpeechBubble->toArray());
    }

    /**
     * @test
     */
    public function it_is_a_button()
    {
        $button = Button::speechBubble('some text');
        $this->assertEquals(Button::TYPE_BUTTON, $button['type']);
    }

    /**
     * @test
     */
    public function it_has_the_css_class_for_speech_bubble()
    {
        $button = Button::speechBubble('some text');
        $this->assertStringMatchesFormat('button--speech-bubble', $button['classes']);
    }

    /**
     * @test
     */
    public function it_has_no_explicit_css_class_set_for_size()
    {
        $prohibitedClasses = [
            Button::SIZE_EXTRA_SMALL,
            Button::SIZE_SMALL,
            Button::SIZE_MEDIUM,
        ];
        $buttonClasses = (Button::speechBubble('some text'))['classes'];
        foreach ($prohibitedClasses as $prohibitedClass) {
            $this->assertStringNotMatchesFormat($prohibitedClass, $buttonClasses);
        }
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [Button::speechBubble('the text')],
            'full' => [Button::speechBubble('the text', 'theName', 'theId', false)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}
