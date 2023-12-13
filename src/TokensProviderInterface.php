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
   *
   * The safest way to achieve this is to include this inside the method.
   * @code
   * $tokens = (new MyTokenProvider())->getTokens())
   * $creator = (new \AKlump\TokenEngine\Helpers\CreateExamples());
   * return $creator($tokens, function (\AKlump\TokenEngine\TokenInterface $token) {
   *   switch ($token->token()) {
   *     case 'first_name':
   *       $token
   *         ->setValue('Mark')
   *         ->setDescription('Their first name.');
   *       break;
   *
   *     case 'last_name':
   *       $token
   *         ->setValue('Smith')
   *         ->setDescription('Their last name.');
   *       break;
   *   }
   * });
   * @endcode
   */
  public static function getExampleTokens(): TokenCollection;

}
