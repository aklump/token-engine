<?php

namespace AKlump\TokenEngine;

/**
 * Classes that provide tokens, which can be documented should implement this class.
 */
interface TokensProviderInterface {

  /**
   * @return \AKlump\TokenEngine\TokenCollection
   */
  public function getTokens(): TokenCollection;

  /**
   * @return \AKlump\TokenEngine\TokenCollection
   *   The values should be example values and all the descriptions should be
   *   filled out.  This will be used for documentation generation.
   */
  public static function getExampleTokens(): TokenCollection;

}
