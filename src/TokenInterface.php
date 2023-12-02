<?php

namespace AKlump\TokenEngine;

interface TokenInterface {

  public function token(): string;

  public function value(array $context);

  public function description(): string;

}
