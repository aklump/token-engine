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
   * Get a token set to be used for documentation that reflects getTokens().
   *
   * @return \AKlump\TokenEngine\TokenCollection
   *   The values should be example values and all the descriptions should be
   *   filled out.  This will be used for documentation generation.
   *
   * The safest way to achieve this is to include the following inside this
   * method.  It is safe for two reasons, the values will be empty and the
   * tokens will be the same as returned by getTokens().  Therefore your
   * documentation will be in sync and secure.
   * @code
   * $tokens = (new self())->getTokens())
   * return (new \AKlump\TokenEngine\Helpers\CreateExamples())($tokens);
   * @endcode
   *
   * You may want to populate the example values and/or add descriptions hence
   * the callback argument as shown here.
   * @code
   * $tokens = (new self())->getTokens())
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
