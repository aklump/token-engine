<?php

namespace AKlump\TokenEngine\Tests\Unit\Helpers;

use AKlump\TokenEngine\Helpers\ArrayStylizeKeys;
use AKlump\TokenEngine\Styles\AtStyle;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\Helpers\ArrayStylizeKeys
 * @uses   \AKlump\TokenEngine\Helpers\StylizeString
 * @uses   \AKlump\TokenEngine\Styles\AtStyle
 */
class ArrayStylizeKeysTest extends TestCase {

  public function testInvoke() {
    $array = ['foo' => 'bar'];
    $result = (new ArrayStylizeKeys(new AtStyle()))($array);
    $this->assertSame(['@foo' => 'bar'], $result);
  }
}
