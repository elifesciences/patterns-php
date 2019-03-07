<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel;
use eLife\Patterns\ViewModel\FlexibleViewModel;
use PHPUnit\Framework\TestCase;

final class FlexibleViewModelTest extends TestCase
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
    public function it_can_be_created_from_anther_view_model()
    {
        $viewModel1 = new FlexibleViewModel('/foo', ['bar' => 'baz']);

        $viewModel2 = FlexibleViewModel::fromViewModel($viewModel1);

        $this->assertSame($viewModel1->getTemplateName(), $viewModel2->getTemplateName());
        $this->assertSame($viewModel1->toArray(), $viewModel2->toArray());
    }

    /**
     * @test
     */
    public function it_can_be_created_with_a_new_property()
    {
        $viewModel1 = new FlexibleViewModel('/foo', ['bar' => 'baz']);

        $viewModel2 = $viewModel1->withProperty('qux', 'quxx');

        $this->assertSame($viewModel1->getTemplateName(), $viewModel2->getTemplateName());
        $this->assertSame(array_merge($viewModel1->toArray(), ['qux' => 'quxx']), $viewModel2->toArray());
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
