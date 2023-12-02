<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\TokenStyleInterface;

/**
 * Change all values in an array to stylized values, e.g. 'foo' => '{{ foo }}'.
 */
class ArrayStylizeValues {

  private TokenStyleInterface $style;

  public function __construct(TokenStyleInterface $style) {
    $this->style = $style;
  }

  public function __invoke(array $array) {
    $values = array_map(fn($value) => (new StylizeString($this->style))($value), $array);

    return array_combine(array_keys($array), $values);
  }

}
