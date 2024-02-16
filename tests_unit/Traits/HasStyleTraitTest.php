<?php

namespace AKlump\TokenEngine\Tests\Unit\Traits;

use AKlump\TokenEngine\Styles\AtStyle;
use AKlump\TokenEngine\Styles\DoubleUnderscoreStyle;
use AKlump\TokenEngine\Traits\HasStyleTrait;

/**
 * @covers \AKlump\TokenEngine\Tests\Unit\Traits\Foo
 */
class HasStyleTraitTest extends \PHPUnit\Framework\TestCase {

  public function testSetStyle() {
    $foo = new Foo(new AtStyle());
    $this->assertInstanceOf(AtStyle::class, $foo->getStyle());
    $this->assertSame($foo, $foo->setStyle(new DoubleUnderscoreStyle()));
    $this->assertInstanceOf(DoubleUnderscoreStyle::class, $foo->getStyle());
  }
}


class Foo {

  use HasStyleTrait;
}
