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
            'count' => 0,
            'type' => 'button',
            'name' => 'theName',
            'id' => 'theId',

            'text' => '<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations (there are currently &#8220; annotations on this page).</span>',
        ];

        $buttonSpeechBubble = Button::speechBubble($data['count'], $data['name'], $data['id']);
        unset($data['count']);
        $this->assertSameWithoutOrder($data, $buttonSpeechBubble->toArray());
    }

    /**
     * @test
     */
    public function it_is_a_button()
    {
        $button = Button::speechBubble(1);
        $this->assertEquals(Button::TYPE_BUTTON, $button['type']);
    }

    /**
     * @test
     */
    public function it_has_the_css_class_for_speech_bubble()
    {
        $button = Button::speechBubble(0);
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
        $buttonClasses = (Button::speechBubble(0))['classes'];
        foreach ($prohibitedClasses as $prohibitedClass) {
            $this->assertStringNotMatchesFormat($prohibitedClass, $buttonClasses);
        }
    }

    /**
     * @test
     */
    public function it_has_the_css_class_indicating_populated_when_there_is_a_count()
    {
        $expectedButtonClasses = 'button--speech-bubble button--speech-bubble-populated';
        $observedButtonClasses = (Button::speechBubble(5))['classes'];
        $this->assertStringMatchesFormat($expectedButtonClasses, $observedButtonClasses);
    }

    /**
     * @test
     */
    public function it_does_not_have_the_css_class_indicating_populated_when_there_is_no_count()
    {
        $expectedButtonClasses = 'button--speech-bubble';
        $observedButtonClasses = (Button::speechBubble(0))['classes'];
        $this->assertStringMatchesFormat($expectedButtonClasses, $observedButtonClasses);
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [Button::speechBubble(0)],
            'full' => [Button::speechBubble(3, 'theName', 'theId', false)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}
