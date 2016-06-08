<?php

namespace tests\eLife\Patterns\ViewModel;

use ArrayObject;
use eLife\Patterns\ViewModel;
use JsonSchema\Validator;
use PHPUnit_Framework_TestCase;
use stdClass;
use Symfony\Component\Yaml\Yaml;
use tests\eLife\Patterns\PuliAwareTestCase;
use Traversable;

abstract class ViewModelTest extends PHPUnit_Framework_TestCase
{
    use PuliAwareTestCase;

    /**
     * @test
     */
    abstract public function it_has_data();

    /**
     * @test
     */
    final public function it_is_a_view_model()
    {
        $viewModel = $this->createViewModel();

        $this->assertInstanceOf(ViewModel::class, $viewModel);
    }

    /**
     * @test
     */
    final public function it_has_a_template()
    {
        $viewModel = $this->createViewModel();

        $this->assertSame($this->expectedTemplate(), $viewModel->getTemplateName());
        $this->puli->get($viewModel->getTemplateName());
    }

    /**
     * @test
     * @depends it_has_a_template
     */
    final public function it_has_a_definition()
    {
        $this->loadDefinition();
    }

    /**
     * @test
     */
    final public function it_is_array_accessible()
    {
        $viewModel = $this->createViewModel();
        $data = $viewModel->toArray();

        foreach ($data as $key => $value) {
            $this->assertSame($value, $viewModel[$key]);
        }
    }

    /**
     * @test
     * @dataProvider viewModelProvider
     * @depends      it_has_a_definition
     */
    final public function it_matches_the_schema(ViewModel $viewModel)
    {
        $validator = new Validator();

        $validator->check(json_decode(json_encode($viewModel->toArray())), $this->loadDefinition()->schema);

        $message = '';
        foreach ($validator->getErrors() as $error) {
            $message .= sprintf("[%s] %s\n", $error['property'], $error['message']);
        };

        $this->assertTrue($validator->isValid(), $message);
    }

    /**
     * @test
     * @depends it_has_a_definition
     */
    final public function it_has_assets()
    {
        $viewModel = $this->createViewModel();

        $this->assertSame(iterator_to_array($this->expectedStylesheets()),
            iterator_to_array($viewModel->getStyleSheets()));
        $this->assertSame(iterator_to_array($this->expectedInlineStylesheets($viewModel)),
            iterator_to_array($viewModel->getInlineStyleSheets()));
        $this->assertSame(iterator_to_array($this->expectedJavaScripts()),
            iterator_to_array($viewModel->getJavaScripts()));
        $this->assertSame(iterator_to_array($this->expectedInlineJavaScripts($viewModel)),
            iterator_to_array($viewModel->getInlineJavaScripts()));
    }

    abstract public function viewModelProvider() : array;

    final protected function createViewModel() : ViewModel
    {
        return array_values($this->viewModelProvider())[0][0];
    }

    abstract protected function expectedTemplate() : string;

    private function expectedStylesheets() : Traversable
    {
        $definition = $this->loadDefinition();

        foreach ($definition->assets->css as $stylesheet) {
            yield '/elife/patterns/assets/css/' . $stylesheet;
        }
    }

    protected function expectedInlineStylesheets(ViewModel $viewModel) : Traversable
    {
        return new ArrayObject();
    }

    private function expectedJavaScripts() : Traversable
    {
        $definition = $this->loadDefinition();

        foreach ($definition->assets->js as $javaScript) {
            yield '/elife/patterns/assets/js/' . $javaScript;
        }
    }

    protected function expectedInlineJavaScripts(ViewModel $viewModel) : Traversable
    {
        return new ArrayObject();
    }

    final private function loadDefinition() : stdClass
    {
        $templateName = $this->puli->get($this->createViewModel()->getTemplateName())->getName();
        $yamlFile = '/elife/patterns/definitions/' . substr($templateName, 0, -8) . 'yaml';

        return Yaml::parse($this->puli->get($yamlFile)->getBody(), true, false, true);
    }
}
