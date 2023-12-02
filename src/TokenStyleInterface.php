<?php

namespace AKlump\TokenEngine;

interface TokenStyleInterface {

  public function getPrefix(): string;

  public function getSuffix(): string;

}
