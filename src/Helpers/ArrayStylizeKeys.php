<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\TokenStyleInterface;

/**
 * Change all keys in an array to stylized keys, e.g. 'foo' => '{{ foo }}'.
 */
class ArrayStylizeKeys {

  private TokenStyleInterface $style;

  public function __construct(TokenStyleInterface $style) {
    $this->style = $style;
  }

  public function __invoke(array $array) {
    $keys = array_map(fn($key) => (new StylizeString($this->style))($key), array_keys($array));

    return array_combine($keys, $array);
  }

}
