<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\Traits\HasStyleTrait;

/**
 * Change all keys in an array to stylized keys, e.g. 'foo' => '{{ foo }}'.
 */
class ArrayStylizeKeys {

  use HasStyleTrait;

  public function __invoke(array $array) {
    $keys = array_map(fn($key) => (new StylizeString($this->getStyle()))($key), array_keys($array));

    return array_combine($keys, $array);
  }

}
