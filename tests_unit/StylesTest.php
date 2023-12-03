<?php

namespace AKlump\TokenEngine\Tests\Unit;

use AKlump\TokenEngine\Styles\AtStyle;
use AKlump\TokenEngine\Styles\CustomStyle;
use AKlump\TokenEngine\Styles\DoubleUnderscoreStyle;
use AKlump\TokenEngine\Styles\TwigStyle;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\Styles\AtStyle
 * @covers \AKlump\TokenEngine\Styles\CustomStyle
 * @covers \AKlump\TokenEngine\Styles\DoubleUnderscoreStyle
 * @covers \AKlump\TokenEngine\Styles\TwigStyle
 */
class StylesTest extends TestCase {

  public function testCustomStyle() {
    $style = new CustomStyle('@--', '--@');
    $this->assertSame('@--', $style->getPrefix());
    $this->assertSame('--@', $style->getSuffix());

    $style = $style->setPrefix('<el>')->setSuffix('</el>');
    $this->assertSame('<el>', $style->getPrefix());
    $this->assertSame('</el>', $style->getSuffix());
  }

  public function testDoubleUnderscoreStyle() {
    $style = new DoubleUnderscoreStyle();
    $this->assertSame('__', $style->getPrefix());
    $this->assertSame('', $style->getSuffix());
  }

  public function testTwigStyle() {
    $style = new TwigStyle();
    $this->assertSame('{{ ', $style->getPrefix());
    $this->assertSame(' }}', $style->getSuffix());
  }

  public function testAtStyle() {
    $style = new AtStyle();
    $this->assertSame('@', $style->getPrefix());
    $this->assertSame('', $style->getSuffix());
  }

}
