<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class ModalWindow implements ViewModel {

  use ArrayAccessFromProperties;
  use ArrayFromProperties;

  private $title;
  private $closeBtnText;
  private $body;

  private function __construct(string $title, string $body, string $closeBtnText) {


    Assertion::notBlank($title);
    Assertion::notBlank($body);
    Assertion::notBlank($closeBtnText);

    $this->title = $title['name'];
    $this->body = $body;
    $this->closeBtnText = $closeBtnText;
  }


  public function getTemplateName() : string
  {
    return 'resources/templates/modal-window.mustache';
  }
}
