<?php

namespace AKlump\TokenEngine\Styles;

class CustomStyle implements \AKlump\TokenEngine\TokenStyleInterface {

  private string $prefix;

  private string $suffix;

  public function __construct(string $prefix, string $suffix = '') {
    $this->setPrefix($prefix)->setSuffix($suffix);
  }

  public function setPrefix(string $prefix): self {
    $this->prefix = $prefix;

    return $this;
  }

  public function setSuffix(string $suffix): self {
    $this->suffix = $suffix;

    return $this;
  }

  public function getPrefix(): string {
    return $this->prefix;
  }

  public function getSuffix(): string {
    return $this->suffix;
  }
}
