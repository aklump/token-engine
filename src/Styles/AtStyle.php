<?php

namespace AKlump\TokenEngine\Styles;

use AKlump\TokenEngine\TokenStyleInterface;

class AtStyle implements TokenStyleInterface {

  public function getPrefix(): string {
    return '@';
  }

  public function getSuffix(): string {
    return '';
  }

}
