<?php

namespace AKlump\TokenEngine\Tests\Unit\Helpers;

use AKlump\TokenEngine\Helpers\ArrayStylizeKeys;
use AKlump\TokenEngine\Helpers\ArrayStylizeValues;
use AKlump\TokenEngine\Styles\AtStyle;
use AKlump\TokenEngine\Styles\TwigStyle;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\Helpers\ArrayStylizeValues
 * @uses   \AKlump\TokenEngine\Helpers\StylizeString
 * @uses   \AKlump\TokenEngine\Styles\TwigStyle
 */
class ArrayStylizeValuesTest extends TestCase {

  public function testInvoke() {
    $array = ['foo' => 'bar'];
    $result = (new ArrayStylizeValues(new TwigStyle()))($array);
    $this->assertSame(['foo' => '{{ bar }}'], $result);
  }
}
