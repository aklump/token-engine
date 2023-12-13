<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\Token;
use AKlump\TokenEngine\TokenCollection;
use AKlump\TokenEngine\TokenInterface;

class CreateExamples {

  public function __invoke(TokenCollection $tokens, callable $callback = NULL): TokenCollection {
    $examples = new TokenCollection();
    $extra = $examples->diffTokens($tokens);
    if ($extra) {
      $examples = $examples->filter(fn(TokenInterface $token) => !in_array($token->token(), $extra));
    }
    $missing = $tokens->diffTokens($examples);
    if ($missing) {
      foreach ($missing as $token_name) {
        $token = Token::create($token_name);
        if (is_callable($callback)) {
          $callback($token);
        }
        $examples->add($token);
      }
    }

    return $examples;
  }

}
