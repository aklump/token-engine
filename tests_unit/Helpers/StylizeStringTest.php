<?php

namespace AKlump\TokenEngine\Tests\Unit\Helpers;

use AKlump\TokenEngine\Helpers\StylizeString;
use AKlump\TokenEngine\Styles\DoubleUnderscoreStyle;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\Helpers\StylizeString
 * @uses   \AKlump\TokenEngine\Styles\DoubleUnderscoreStyle
 */
class StylizeStringTest extends TestCase {

  public function testInvoke() {
    $result = (new StylizeString(new DoubleUnderscoreStyle()))('foo');
    $this->assertSame('__foo', $result);
  }
}
