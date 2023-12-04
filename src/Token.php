<?php

namespace AKlump\TokenEngine;

class Token implements TokenInterface {

  protected string $tokenValue;

  protected string $description;

  /**
   * @var mixed|callable
   */
  protected $valueValue;

  public static function create(string $token, $value = NULL, string $description = '') {
    $token = new static($token, $value);
    $token->setDescription($description);

    return $token;
  }

  public function __construct(string $token, $value = NULL, string $description = '') {
    $this->setToken($token);
    $this->setValue($value);
    $this->setDescription($description);
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

  public function setToken(string $token): self {
    $this->tokenValue = $token;

    return $this;
  }

  public function value(array $context = []) {
    if (is_object($this->valueValue)) {
      if (is_callable($this->valueValue)) {
        $callable = $this->valueValue;

        return $callable($context, $this);
      }

      return (string) $this->valueValue;
    }

    return $this->valueValue;
  }

}
