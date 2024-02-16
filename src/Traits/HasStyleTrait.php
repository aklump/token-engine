<?php

namespace AKlump\TokenEngine\Traits;

use AKlump\TokenEngine\TokenStyleInterface;

trait HasStyleTrait {

  protected TokenStyleInterface $style;

  /**
   * Sets the token style.
   *
   * @param TokenStyleInterface $style The token style interface.
   *
   * @return self The modified instance of the class.
   */
  public function setStyle(TokenStyleInterface $style): self {
    $this->style = $style;

    return $this;
  }

  /**
   * Get the token style.
   *
   * @return TokenStyleInterface The token style.
   */
  public function getStyle(): TokenStyleInterface {
    return $this->style;
  }

}
