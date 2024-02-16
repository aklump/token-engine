<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\Traits\HasStyleTrait;

/**
 * Change all values in an array to stylized values, e.g. 'foo' => '{{ foo }}'.
 */
class ArrayStylizeValues {

  use HasStyleTrait;

  public function __invoke(array $array) {
    $values = array_map(fn($value) => (new StylizeString($this->getStyle()))($value), $array);

    return array_combine(array_keys($array), $values);
  }

}
