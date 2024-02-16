<?php

namespace AKlump\TokenEngine\Traits;

use AKlump\TokenEngine\TokenStyleInterface;

/**
 * Please beware again of the potential "constructor collision" if you use this
 * trait in a class which also has a constructor. In PHP, trait's constructor
 * won't get called if the using class has a constructor.  In such case you
 * should use HasStyleTrait.
 *
 * @see \AKlump\TokenEngine\Traits\HasStyleTrait
 */
trait ConstructsWithStyleTrait {

  use HasStyleTrait;

  /**
   * Class constructor.
   *
   * @param TokenStyleInterface $style The token style interface.
   *
   * @return void
   */
  public function __construct(TokenStyleInterface $style) {
    $this->setStyle($style);
  }

}
