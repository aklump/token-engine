<?php

namespace AKlump\TokenEngine\Tests\Unit;

use AKlump\TokenEngine\ReplaceTokens;
use AKlump\TokenEngine\Styles\AtStyle;
use AKlump\TokenEngine\Styles\DoubleUnderscoreStyle;
use AKlump\TokenEngine\Styles\TwigStyle;
use AKlump\TokenEngine\TokenCollection;
use AKlump\TokenEngine\TokenStyleInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\ReplaceTokens
 * @uses   \AKlump\TokenEngine\TokenCollection
 * @uses   \AKlump\TokenEngine\Styles\AtStyle
 * @uses   \AKlump\TokenEngine\Styles\TwigStyle
 * @uses   \AKlump\TokenEngine\Styles\DoubleUnderscoreStyle
 * @uses   \AKlump\TokenEngine\Token
 */
class ReplaceTokensTest extends TestCase {

  public function testHeyPeterShout() {
    // Create a new token collection.
    $tokens = new \AKlump\TokenEngine\TokenCollection();

    // Create a token with a callable value.
    $callable_token = new \AKlump\TokenEngine\Token('first|toUpperCase');
    $callable_token->setValue(function (array $context) {
      return strtoupper($context['first']);
    });
    $tokens->add($callable_token);

    // Use that token in a string template.
    $template = 'HEY {{ first|toUpperCase }}!';

    // Create the styleized replacer.
    $replace = (new \AKlump\TokenEngine\ReplaceTokens($tokens, new \AKlump\TokenEngine\Styles\TwigStyle()));

    // Replace the token with runtime context.
    $runtime_context = ['first' => 'Peter'];
    $shout = $replace($template, $runtime_context);

    $this->assertSame('HEY PETER!', $shout);
  }

  public function testReplacementOfCallableTokenWithContextWorksAsExpected() {
    $tokens = TokenCollection::createFromKeyValueArray([
      '$value x 2' => fn(array $context) => $context['value'] * 2,
    ]);
    $replace_tokens = (new ReplaceTokens($tokens, new TwigStyle()));
    $this->assertSame('50', $replace_tokens('{{ $value x 2 }}', [
      'value' => 25,
    ]));
  }

  public function testReplacementHandlesLongerTokensBeforeShorterOnes() {
    $tokens = TokenCollection::createFromKeyValueArray([
      'dir' => '/lorem/ipsum',
      'directory' => '/foo/bar',
    ]);
    $replace_tokens = (new ReplaceTokens($tokens, new AtStyle()));
    $this->assertSame('/lorem/ipsum /foo/bar', $replace_tokens('@dir @directory'));

    $tokens = TokenCollection::createFromKeyValueArray([
      'directory' => '/foo/bar',
      'dir' => '/lorem/ipsum',
    ]);
    $replace_tokens = (new ReplaceTokens($tokens, new AtStyle()));
    $this->assertSame('/lorem/ipsum /foo/bar', $replace_tokens('@dir @directory'));
  }

  public function dataFortestSimpleReplacementProvider() {
    $tests = [];
    $tests[] = [
      'Welcome Mary Smith,',
      'Welcome __first __last,',
      new DoubleUnderscoreStyle(),
    ];
    $tests[] = [
      'Welcome Mary Smith,',
      'Welcome {{ first }} {{ last }},',
      new TwigStyle(),
    ];
    $tests[] = [
      'Welcome Mary Smith,',
      'Welcome @first @last,',
      new AtStyle(),
    ];

    return $tests;
  }

  /**
   * @dataProvider dataFortestSimpleReplacementProvider
   */
  public function testSimpleReplacement(string $expected, string $template, TokenStyleInterface $style) {
    $tokens = TokenCollection::createFromKeyValueArray([
      'first' => 'Mary',
      'last' => 'Smith',
    ]);
    $replace_tokens = (new ReplaceTokens($tokens, $style));
    $this->assertSame($expected, $replace_tokens($template));
  }

}
