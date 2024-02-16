<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\TokenCollection;
use AKlump\TokenEngine\TokenStyleInterface;

/**
 * Class ScanTokensByStyle
 *
 * This class is used to scan tokens from a given subject based on a specified token style.
 */
class ScanTokensByStyle {

  private TokenStyleInterface $style;

  public function __construct(TokenStyleInterface $style) {
    $this->style = $style;
  }

  public function __invoke(string $subject): TokenCollection {
    $suffix = $this->prepareSuffix($this->style->getSuffix());
    $prefix = preg_quote($this->style->getPrefix());
    $regex = $this->prepareRegex($prefix, $suffix);
    preg_match_all($regex, $subject, $matches, PREG_SET_ORDER);
    $tokens = $this->convertMatchesToTokens($matches);

    return TokenCollection::createFromKeyValueArray(array_fill_keys($tokens, NULL));
  }

  public function prepareSuffix($suffix): string {
    if (!empty($suffix)) {
      $suffix = preg_quote($suffix);
    }
    else {
      $suffix = '\W';
    }

    return $suffix;
  }

  public function prepareRegex($prefix, $suffix): string {
    return sprintf('#(%s)(.+?)(%s)#', $prefix, $suffix);
  }

  private function convertMatchesToTokens(array $matches): array {
    $tokens = array_map(fn($match) => $match[2], $matches);

    return array_unique($tokens);
  }
}
