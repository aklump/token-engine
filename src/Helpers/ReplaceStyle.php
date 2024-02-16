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

  /**
   * Invokes the __invoke method.
   *
   * @param TokenStyleInterface $search The search token style.
   * @param TokenStyleInterface $replace The replace token style.
   * @param string $subject The subject string to perform the replacement on.
   * @param callable|null $callback The optional callback function will receive
   * the token value only (less prefix/suffix) and must return a token value.
   * You would only use this if you wanted to mutate the replaced token.
   *
   * @return string The resulting string after performing the replacements.
   */
  public function __invoke(TokenStyleInterface $search, TokenStyleInterface $replace, string $subject, callable $callback = NULL): string {
    list($suffix, $include_matched_suffix) = $this->prepareSuffix($search->getSuffix());
    $prefix = preg_quote($search->getPrefix());
    $regex = $this->prepareRegex($prefix, $suffix);

    return preg_replace_callback($regex, function (array $matches) use ($replace, $include_matched_suffix, $callback) {
      return $this->replaceMatch($matches, $replace, $include_matched_suffix, $callback);
    }, $subject);
  }

  protected function prepareSuffix($suffix): array {
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

  protected function prepareRegex($prefix, $suffix): string {
    return sprintf('#(%s)(.+?)(%s)#', $prefix, $suffix);
  }

  protected function replaceMatch(array $matches, TokenStyleInterface $replace, bool $include_matched_suffix, callable $callback = NULL): string {
    $value = $matches[2];
    if (is_callable($callback)) {
      $value = $callback($value);
    }
    $result = $replace->getPrefix() . $value;
    $result .= $replace->getSuffix();
    if ($include_matched_suffix) {
      $result .= $matches[3];
    }

    return $result;
  }

}
