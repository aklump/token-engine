<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\TokenStyleInterface;

/**
 * Wrap a string in a style e.g. 'foo' => '{{ foo }}'.
 */
class StylizeString {

  private TokenStyleInterface $style;

  public function __construct(TokenStyleInterface $style) {
    $this->style = $style;
  }

  public function __invoke(string $string) {
    return $this->style->getPrefix() . $string . $this->style->getSuffix();
  }

}
