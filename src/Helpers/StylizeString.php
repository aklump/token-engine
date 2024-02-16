<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\Traits\ConstructsWithStyleTrait;

/**
 * Wrap a string in a style e.g. 'foo' => '{{ foo }}'.
 */
class StylizeString {

  use ConstructsWithStyleTrait;

  public function __invoke(string $string) {
    return $this->getStyle()->getPrefix() . $string . $this->getStyle()->getSuffix();
  }

}
