<?php

namespace AKlump\TokenEngine\Tests\Unit\Helpers;

use AKlump\TokenEngine\Helpers\ScanTokensByStyle;
use AKlump\TokenEngine\Styles\AtStyle;
use AKlump\TokenEngine\Styles\TwigStyle;
use AKlump\TokenEngine\TokenCollection;
use AKlump\TokenEngine\TokenStyleInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\Helpers\ScanTokensByStyle
 * @uses   \AKlump\TokenEngine\TokenCollection
 * @uses   \AKlump\TokenEngine\Token
 * @uses   \AKlump\TokenEngine\Styles\AtStyle
 * @uses   \AKlump\TokenEngine\Styles\TwigStyle
 */
final class ScanTokensByStyleTest extends TestCase {

  public function dataFortestInvokeProvider() {
    $tests = [];
    $tests[] = [
      'lorem @ipsum dolar sit @amet.',
      new AtStyle(),
      ['ipsum', 'amet'],
    ];
    $tests[] = [
      'lorem {{ foo }} dolar sit {{ bar }}. {{ foo }}',
      new TwigStyle(),
      ['foo', 'bar'],
    ];

    return $tests;
  }

  /**
   * @dataProvider dataFortestInvokeProvider
   */
  public function testInvoke(string $subject, TokenStyleInterface $style, array $tokens) {
    $scanned_collection = (new ScanTokensByStyle($style))($subject);
    $this->assertInstanceOf(TokenCollection::class, $scanned_collection);
    $this->assertEquals(array_fill_keys($tokens, NULL), $scanned_collection->toKeyValueArray());
  }
}
