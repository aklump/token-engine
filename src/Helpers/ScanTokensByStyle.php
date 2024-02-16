<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\TokenCollection;
use AKlump\TokenEngine\Traits\ConstructsWithStyleTrait;

/**
 * Class ScanTokensByStyle
 *
 * This class is used to scan tokens from a given subject based on a specified token style.
 */
class ScanTokensByStyle {

  use ConstructsWithStyleTrait;

  /**
   * Invoke the method as a callable.
   *
   * @param string $subject The subject string on which the method will be invoked.
   *
   * @return TokenCollection The collection of tokens created from the matches.
   * All token values will be NULL.
   */
  public function __invoke(string $subject): TokenCollection {
    $suffix = $this->prepareSuffix($this->getStyle()->getSuffix());
    $prefix = preg_quote($this->getStyle()->getPrefix());
    $regex = $this->prepareRegex($prefix, $suffix);
    preg_match_all($regex, $subject, $matches, PREG_SET_ORDER);
    $tokens = $this->convertMatchesToTokens($matches);

    return TokenCollection::createFromKeyValueArray(array_fill_keys($tokens, NULL));
  }

  protected function prepareSuffix($suffix): string {
    if (!empty($suffix)) {
      $suffix = preg_quote($suffix);
    }
    else {
      $suffix = '\W';
    }

    return $suffix;
  }

  protected function prepareRegex($prefix, $suffix): string {
    return sprintf('#(%s)(.+?)(%s)#', $prefix, $suffix);
  }

  protected function convertMatchesToTokens(array $matches): array {
    $tokens = array_map(fn($match) => $match[2], $matches);

    return array_unique($tokens);
  }
}
