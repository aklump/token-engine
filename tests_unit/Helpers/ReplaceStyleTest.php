<?php

namespace AKlump\TokenEngine\Tests\Unit\Helpers;

use AKlump\TokenEngine\Helpers\ReplaceStyle;
use AKlump\TokenEngine\Styles\AtStyle;
use AKlump\TokenEngine\Styles\CustomStyle;
use AKlump\TokenEngine\Styles\DoubleUnderscoreStyle;
use AKlump\TokenEngine\Styles\TwigStyle;
use AKlump\TokenEngine\TokenStyleInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\Helpers\ReplaceStyle
 * @uses   \AKlump\TokenEngine\Styles\AtStyle
 * @uses   \AKlump\TokenEngine\Styles\TwigStyle
 * @uses   \AKlump\TokenEngine\Styles\DoubleUnderscoreStyle
 * @uses   \AKlump\TokenEngine\Styles\CustomStyle
 */
final class ReplaceStyleTest extends TestCase {

  public function testWithCallback() {
    $content_style = new TwigStyle();
    $new_style = new DoubleUnderscoreStyle();
    $content = '{{ lorem }}';
    $expected = '___lorem';

    // This logic comes from Jig where "___foo" is the same as "{{ foo }}".
    $add_underscore_if_original = function ($value) {
      if (substr($value, 0, 1) !== '_') {
        return '_' . $value;
      }

      return $value;
    };

    $result = (new ReplaceStyle())($content_style, $new_style, $content, $add_underscore_if_original);
    $this->assertSame($expected, $result);
  }

  public function dataFortestInvokeProvider() {
    $tests = [];
    $tests[] = [
      'lorem [ipsum] dolar',
      new CustomStyle('[', ']'),
      'lorem {{ ipsum }} dolar',
      new TwigStyle(),
    ];
    $tests[] = [
      'lorem @ipsum dolar',
      new AtStyle(),
      'lorem {{ ipsum }} dolar',
      new TwigStyle(),
    ];
    $tests[] = [
      'lorem @ipsum dolar',
      new AtStyle(),
      'lorem __ipsum dolar',
      new DoubleUnderscoreStyle(),
    ];
    $tests[] = [
      'lorem @ipsum dolar',
      new AtStyle(),
      'lorem @ipsum dolar',
      new AtStyle(),
    ];
    $tests[] = [
      'lorem @ipsum dolar @amet.',
      new AtStyle(),
      'lorem {{ ipsum }} dolar {{ amet }}.',
      new TwigStyle(),
    ];
    $tests[] = [
      'lorem {{ ipsum }} dolar',
      new TwigStyle(),
      'lorem @ipsum dolar',
      new AtStyle(),
    ];
    $tests[] = [
      'lorem {{ ipsum }} dolar',
      new TwigStyle(),
      'lorem __ipsum dolar',
      new DoubleUnderscoreStyle(),
    ];

    return $tests;
  }

  /**
   * @dataProvider dataFortestInvokeProvider
   */
  public function testInvoke(string $content, TokenStyleInterface $content_style, string $expected, TokenStyleInterface $new_style) {
    $result = (new ReplaceStyle())($content_style, $new_style, $content);
    $this->assertSame($expected, $result);
  }
}
