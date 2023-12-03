<?php

namespace AKlump\TokenEngine;

interface TokenInterface {

  public function token(): string;

  public function setToken(string $token): self;

  public function value(array $context);

  public function setValue($value): self;

  public function description(): string;

  public function setDescription(string $description): self;

}
