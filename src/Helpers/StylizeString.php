<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\Traits\HasStyleTrait;

/**
 * Wrap a string in a style e.g. 'foo' => '{{ foo }}'.
 */
class StylizeString {

  use HasStyleTrait;

  public function __invoke(string $string) {
    return $this->getStyle()->getPrefix() . $string . $this->getStyle()->getSuffix();
  }

}
