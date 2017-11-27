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
            'text' => '<span aria-hidden="true">3</span><span class="visuallyhidden">Open annotations (there are currently 3 annotations on this page).</span>',
            'type' => 'button',
            'name' => 'theName',
            'id' => 'theId',
            '$isPopulated' => true,
        ];

        $buttonSpeechBubble = Button::speechBubble($data['text'], $data['$isPopulated'], $data['name'], $data['id']);
        unset($data['$isPopulated']);
        $this->assertSameWithoutOrder($data, $buttonSpeechBubble->toArray());
    }

    /**
     * @test
     */
    public function it_is_a_button()
    {
        $button = Button::speechBubble('<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations (there are currently 0 annotations on this page).</span>');
        $this->assertEquals(Button::TYPE_BUTTON, $button['type']);
    }

    /**
     * @test
     */
    public function it_has_the_css_class_for_speech_bubble()
    {
        $button = Button::speechBubble('<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations (there are currently 0 annotations on this page).</span>');
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
        $buttonClasses = (Button::speechBubble('<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations (there are currently 0 annotations on this page).</span>'))['classes'];
        foreach ($prohibitedClasses as $prohibitedClass) {
            $this->assertStringNotMatchesFormat($prohibitedClass, $buttonClasses);
        }
    }

    /**
     * @test
     */
    public function it_has_the_css_class_indicating_populated_when_it_is()
    {
        $expectedButtonClasses = 'button--speech-bubble button--speech-bubble-populated';
        $observedButtonClasses = (Button::speechBubble('<span aria-hidden="true">3</span><span class="visuallyhidden">Open annotations (there are currently 3 annotations on this page).</span>', true, null, null, true))['classes'];
        $this->assertStringMatchesFormat($expectedButtonClasses, $observedButtonClasses);
    }

    /**
     * @test
     */
    public function it_lacks_the_css_class_indicating_populated_when_it_is_not()
    {
        $expectedButtonClasses = 'button--speech-bubble';
        $observedButtonClasses = (Button::speechBubble('<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations (there are currently no annotations on this page).</span>'))['classes'];
        $this->assertStringMatchesFormat($expectedButtonClasses, $observedButtonClasses);
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [Button::speechBubble('<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations (there are currently no annotations on this page).</span>\'')],
            'full' => [Button::speechBubble('<span aria-hidden="true">3</span><span class="visuallyhidden">Open annotations (there are currently 3 annotations on this page).</span>', 'theId', true, 'theName', true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}
