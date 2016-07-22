<?php

namespace tests\eLife\Patterns\ViewModel;

use ArrayObject;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel;
use eLife\Patterns\ViewModel\FlexibleViewModel;
use PHPUnit_Framework_TestCase;
use function eLife\Patterns\flatten;
use function eLife\Patterns\sanitise_traversable;

final class FlexibleViewModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_a_view_model()
    {
        $viewModel = new FlexibleViewModel('/foo', ['bar' => 'baz']);

        $this->assertInstanceOf(ViewModel::class, $viewModel);
    }

    /**
     * @test
     */
    public function it_has_a_template()
    {
        $viewModel = new FlexibleViewModel('/foo', ['bar' => 'baz']);

        $this->assertSame('/foo', $viewModel->getTemplateName());
    }

    /**
     * @test
     */
    public function it_is_array_accessible()
    {
        $viewModel = new FlexibleViewModel('/foo', ['bar' => 'baz']);
        $data = $viewModel->toArray();

        foreach ($data as $key => $value) {
            $actual = $this->handleValue($viewModel[$key]);

            $this->assertSame($value, $actual);
        }
    }

    /**
     * @test
     */
    public function it_can_not_have_assets()
    {
        $viewModel = new FlexibleViewModel('/foo', ['bar' => 'baz']);

        $this->assertEmpty($viewModel->getStyleSheets());
        $this->assertEmpty($viewModel->getInlineStyleSheets());
        $this->assertEmpty($viewModel->getJavaScripts());
        $this->assertEmpty($viewModel->getInlineJavaScripts());
    }

    /**
     * @test
     */
    public function it_can_have_assets()
    {
        $viewModel = new FlexibleViewModel(
            '/foo',
            ['bar' => 'baz'],
            $styleSheets = new ArrayObject(['qux']),
            $inlineStyleSheets = new ArrayObject(['quxx']),
            $javaScripts = new ArrayObject(['corge']),
            $inlineJavaScripts = new ArrayObject(['grault'])
        );

        $expectedStylesheets = iterator_to_array(sanitise_traversable($styleSheets));
        $actualStyleSheets = iterator_to_array(sanitise_traversable($viewModel->getStyleSheets()));

        $this->assertSame($expectedStylesheets, $actualStyleSheets);

        $expectedInlineStylesheets = iterator_to_array(flatten($inlineStyleSheets));
        $actualInlineStyleSheets = iterator_to_array(flatten($viewModel->getInlineStyleSheets()));

        $this->assertSame($expectedInlineStylesheets, $actualInlineStyleSheets);

        $expectedJavaScripts = iterator_to_array(sanitise_traversable($javaScripts));
        $actualJavaScripts = iterator_to_array(sanitise_traversable($viewModel->getJavaScripts()));

        $this->assertSame($expectedJavaScripts, $actualJavaScripts);

        $expectedInlineJavaScripts = iterator_to_array(flatten($inlineJavaScripts));
        $actualInlineJavaScripts = iterator_to_array(flatten($viewModel->getInlineJavaScripts()));

        $this->assertSame($expectedInlineJavaScripts, $actualInlineJavaScripts);
    }

    /**
     * @test
     */
    public function it_can_be_created_from_anther_view_model()
    {
        $viewModel1 = new FlexibleViewModel('/foo', ['bar' => 'baz'], new ArrayObject(['/css']),
            new ArrayObject(['inline CSS']), new ArrayObject(['/js']), new ArrayObject(['inline JS']));

        $viewModel2 = FlexibleViewModel::fromViewModel($viewModel1);

        $this->assertSame($viewModel1->getTemplateName(), $viewModel2->getTemplateName());
        $this->assertSame($viewModel1->toArray(), $viewModel2->toArray());
        $this->assertEquals($viewModel1->getStyleSheets(), $viewModel2->getStyleSheets());
        $this->assertEquals($viewModel1->getInlineStyleSheets(), $viewModel2->getInlineStyleSheets());
        $this->assertEquals($viewModel1->getJavaScripts(), $viewModel2->getJavaScripts());
        $this->assertEquals($viewModel1->getInlineJavaScripts(), $viewModel2->getInlineJavaScripts());
    }

    /**
     * @test
     */
    public function it_can_be_created_with_a_new_property()
    {
        $viewModel1 = new FlexibleViewModel('/foo', ['bar' => 'baz'], new ArrayObject(['/css']),
            new ArrayObject(['inline CSS']), new ArrayObject(['/js']), new ArrayObject(['inline JS']));

        $viewModel2 = $viewModel1->withProperty('qux', 'quxx');

        $this->assertSame($viewModel1->getTemplateName(), $viewModel2->getTemplateName());
        $this->assertSame(array_merge($viewModel1->toArray(), ['qux' => 'quxx']), $viewModel2->toArray());
        $this->assertEquals($viewModel1->getStyleSheets(), $viewModel2->getStyleSheets());
        $this->assertEquals($viewModel1->getInlineStyleSheets(), $viewModel2->getInlineStyleSheets());
        $this->assertEquals($viewModel1->getJavaScripts(), $viewModel2->getJavaScripts());
        $this->assertEquals($viewModel1->getInlineJavaScripts(), $viewModel2->getInlineJavaScripts());
    }

    private function handleValue($value)
    {
        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                $value[$subKey] = $this->handleValue($subValue);
            }
        }

        if ($value instanceof CastsToArray) {
            return $value->toArray();
        }

        return $value;
    }
}
