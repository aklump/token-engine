<?php

namespace AKlump\TokenEngine\Styles;

use AKlump\TokenEngine\TokenStyleInterface;

class DoubleUnderscoreStyle implements TokenStyleInterface {

  public function getPrefix(): string {
    return '__';
  }

  public function getSuffix(): string {
    return '';
  }

}
