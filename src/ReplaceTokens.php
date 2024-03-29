<?php

namespace AKlump\TokenEngine;

use AKlump\TokenEngine\Traits\HasStyleTrait;

class ReplaceTokens {

  protected TokenCollection $tokens;

  use HasStyleTrait;

  public function __construct(TokenCollection $tokens, TokenStyleInterface $style) {
    $this->tokens = $tokens;
    $this->setStyle($style);
  }

  /**
   * @param string $string
   *   All tokens found in $string will be replaced.  Any tokens not present in
   *   the token collection will remain in the string in their original format;
   *   they are not removed, so you must ensure all necessary tokens are in your
   *   collection.
   * @param array $context
   *   Will be passed to \AKlump\TokenEngine\Token::value().
   *
   * @return string
   */
  public function __invoke(string $string, array $context = []): string {
    $replace = $this->tokens->toKeyValueArray($context);
    // Longer keys must interpolate before shorter keys or outcome is wrong for
    // some styles like AtStyle.
    uksort($replace, fn($a, $b) => mb_strlen($b) - mb_strlen($a));
    // Add the style to the find array.
    $find = array_map(fn(string $key) => $this->style->getPrefix() . $key . $this->style->getSuffix(), array_keys($replace));

    // @url https://www.php.net/manual/en/ref.mbstring.php#109937
    return str_replace($find, $replace, $string);
  }

}
