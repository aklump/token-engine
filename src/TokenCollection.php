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

  public function map(callable $callback): TokenCollection {
    return new static(array_map($callback, $this->data));
  }

}
