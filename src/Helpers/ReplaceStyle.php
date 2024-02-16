<?php

namespace AKlump\TokenEngine\Helpers;

use AKlump\TokenEngine\TokenStyleInterface;

/**
 * Class ReplaceStyle
 *
 * This class provides methods to swap token styles in a given subject.  For
 * example, this class can replace tokens like '{{ foo }}' with '__foo'.  You
 * only need to provide the two style instances and the subject string.
 */
class ReplaceStyle {

  public function __invoke(TokenStyleInterface $search, TokenStyleInterface $replace, string $subject): string {
    list($suffix, $include_matched_suffix) = $this->prepareSuffix($search->getSuffix());
    $prefix = preg_quote($search->getPrefix());
    $regex = $this->prepareRegex($prefix, $suffix);

    return preg_replace_callback($regex, function (array $matches) use ($replace, $include_matched_suffix) {
      return $this->replaceMatch($matches, $replace, $include_matched_suffix);
    }, $subject);
  }

  public function prepareSuffix($suffix): array {
    if (!empty($suffix)) {
      $include_matched_suffix = FALSE;
      $suffix = preg_quote($suffix);
    }
    else {
      $include_matched_suffix = TRUE;
      $suffix = '\W';
    }

    return array($suffix, $include_matched_suffix);
  }

  public function prepareRegex($prefix, $suffix): string {
    return sprintf('#(%s)(.+?)(%s)#', $prefix, $suffix);
  }

  public function replaceMatch(array $matches, TokenStyleInterface $replace, bool $include_matched_suffix): string {
    $result = $replace->getPrefix() . $matches[2];
    $result .= $replace->getSuffix();
    if ($include_matched_suffix) {
      $result .= $matches[3];
    }

    return $result;
  }

}
