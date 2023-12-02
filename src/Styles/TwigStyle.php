<?php

namespace AKlump\TokenEngine\Styles;

use AKlump\TokenEngine\TokenStyleInterface;

class TwigStyle implements TokenStyleInterface {

  public function getPrefix(): string {
    return '{{ ';
  }

  public function getSuffix(): string {
    return ' }}';
  }

}
