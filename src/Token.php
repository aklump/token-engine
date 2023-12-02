<?php

namespace AKlump\TokenEngine;

class Token implements TokenInterface {

  protected string $tokenValue;

  protected string $description;

  /**
   * @var mixed|callable
   */
  protected $valueValue;

  public function __construct(string $token) {
    $this->tokenValue = $token;
  }

  public function setDescription(string $description): self {
    $this->description = $description;

    return $this;
  }

  public function description(): string {
    return $this->description;
  }

  /**
   * Set the value of the token.
   *
   * @param object|callable|mixed $value
   *   Objects must be able to be cast to strings.  Callables will receive
   *   ($context, $this).
   *
   *
   * @return $this
   */
  public function setValue($value): self {
    if (is_array($value)) {
      throw new \InvalidArgumentException('$value cannot be an array');
    }
    if (is_object($value) && !is_callable($value)) {
      if (!method_exists($value, '__toString')) {
        throw new \InvalidArgumentException('$value objects must have a __toString method.');
      }
    }

    $this->valueValue = $value;

    return $this;
  }

  public function token(): string {
    return $this->tokenValue;
  }

  public function value(array $context = []) {
    if (is_callable($this->valueValue)) {
      $callable = $this->valueValue;

      return $callable($context, $this);
    }
    if (is_object($this->valueValue)) {
      return (string) $this->valueValue;
    }

    return $this->valueValue;
  }

}
