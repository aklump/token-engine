<?php

namespace AKlump\TokenEngine;

use Ramsey\Collection\AbstractCollection;

class TokenCollection extends AbstractCollection {

  public function getType(): string {
    return TokenInterface::class;
  }

  /**
   * Create a new token collection.
   *
   * @param \AKlump\TokenEngine\TokenInterface[] $tokens
   *   An array of Token instances.
   */
  public function __construct(array $tokens = []) {
    parent::__construct();
    while ($token = array_shift($tokens)) {
      $this->add($token);
    }
  }

  public function toKeyValueArray(array $context = []): array {
    $key_value_array = [];
    foreach ($this->data as $token) {
      $key_value_array[$token->token()] = $token->value($context);
    }

    return $key_value_array;
  }

  /**
   * @param array $key_value_array
   *   An array of key/value pairs.
   *
   * @return \AKlump\TokenEngine\TokenCollection
   */
  public static function createFromKeyValueArray(array $key_value_array) {
    $collection = new static();
    foreach ($key_value_array as $key => $value) {
      $collection->add((new Token($key))->setValue($value));
    }

    return $collection;
  }

  public function filter(callable $callback): TokenCollection {
    $collection = clone $this;
    $collection->data = array_merge([], array_filter($collection->data, $callback));

    return $collection;
  }

  public function map(callable $callback): TokenCollection {
    return new static(array_map($callback, $this->data));
  }


  /**
   * Find tokens not present in other collections.
   *
   * This method completely ignores the values and operates only on the tokens.
   *
   * @param TokenCollection ...$comparators
   *   An array of TokenCollection objects to compare against.
   *
   * @return array
   *   An array of tokens that are present in the current TokenCollection object
   *   but missing in any of the provided comparators.
   */
  public function diffTokens(TokenCollection ...$comparators): array {
    $comparators = array_map(fn(TokenCollection $c) => $c->toKeyValueArray(), $comparators);
    array_unshift($comparators, $this->toKeyValueArray());

    return array_keys(array_diff_key(...$comparators));
  }

}
