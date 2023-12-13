<?php

namespace AKlump\TokenEngine\Tests\Unit;

use AKlump\TokenEngine\Token;
use AKlump\TokenEngine\TokenCollection;
use AKlump\TokenEngine\TokenInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\TokenCollection
 * @uses   \AKlump\TokenEngine\Token
 */
class TokenCollectionTest extends TestCase {

  public function testDiffTokensOnSelfReturnsNoDiff() {
    $a = (new TokenCollection([
      Token::create('foo', 'Foo'),
      Token::create('bar', 'Foo'),
    ]));
    $diff = $a->diffTokens($a);
    $this->assertCount(0, $diff);
  }

  public function testDiffTokensWorksAsExpectedOnTwoCollections() {
    $a = (new TokenCollection([
      Token::create('foo', 'Foo'),
      Token::create('bar', 'Foo'),
    ]));
    $b = (new TokenCollection([
      Token::create('foo', 'Foo'),
    ]));

    $diff = $a->diffTokens($b);
    $this->assertCount(1, $diff);
    $this->assertSame('bar', $diff[0]);

    $diff = $b->diffTokens($a);
    $this->assertCount(0, $diff);
  }

  public function testDiffTokensWorksWithThreeCollections() {
    $a = (new TokenCollection([
      Token::create('foo', 'Foo'),
      Token::create('bar', 'Foo'),
      Token::create('baz', 'Foo'),
    ]));
    $b = (new TokenCollection([
      Token::create('bar', 'Foo'),
    ]));
    $c = (new TokenCollection([
      Token::create('baz', 'Foo'),
    ]));

    $diff = $a->diffTokens($b, $c);
    $this->assertCount(1, $diff);
    $this->assertSame('foo', $diff[0]);
  }

  public function testFilterWorksAsExpected() {
    $collection = new TokenCollection();
    $collection->add(new Token('zulu'));
    $filtered = $collection->filter(fn(TokenInterface $token) => $token->token() !== 'zulu');
    $this->assertCount(0, $filtered);
  }

  public function testFilterReturnsTokenCollection() {
    $collection = new TokenCollection();
    $collection->add(new Token('zulu'));
    $filtered = $collection->filter(fn($token) => TRUE);
    $this->assertInstanceOf(TokenCollection::class, $filtered);
  }

  public function testFilterReturnsNewInstance() {
    $collection = new TokenCollection();
    $collection->add(new Token('zulu'));
    $filtered = $collection->filter(fn($token) => TRUE);
    $this->assertNotSame($collection, $filtered);
  }

  public function testMapWorksAsExpected() {
    $collection = new TokenCollection();
    $collection->add(new Token('zulu'));
    $mapped = $collection->map(fn(TokenInterface $token) => $token->setValue('Zoo Lou'));
    $this->assertSame('Zoo Lou', $mapped->first()->value());
  }

  public function testMapReturnsTokenCollection() {
    $collection = new TokenCollection();
    $collection->add(new Token('zulu'));
    $mapped = $collection->map(fn($token) => $token);
    $this->assertInstanceOf(TokenCollection::class, $mapped);
  }

  public function testMapReturnsNewInstance() {
    $collection = new TokenCollection();
    $collection->add(new Token('zulu'));
    $mapped = $collection->map(fn($token) => $token);
    $this->assertNotSame($collection, $mapped);
  }

  public function testCanConstructFromAltTokenClassImplementingInterface() {
    $collection = new TokenCollection([new FooToken()]);
    $collection->add(new BarToken());
    $this->assertSame([
      'foo' => 'Foo',
      'bar' => 'Bar',
    ], $collection->toKeyValueArray());
  }

  public function testToKeyValueArrayWithContext() {
    $tokens = [];
    $tokens[] = (new Token('zulu'))->setValue(fn($context) => $context);
    $collection = new TokenCollection($tokens);

    $context = [time()];
    $key_value_array = $collection->toKeyValueArray($context);
    $this->assertSame(['zulu' => $context], $key_value_array);
  }

  public function testToKeyValueArray() {
    $tokens = [];
    $tokens[] = (new Token('zulu'))->setValue('Zulu');
    $collection = new TokenCollection($tokens);
    $key_value_array = $collection->toKeyValueArray();
    $this->assertSame(['zulu' => 'Zulu'], $key_value_array);
  }

  public function testCreateFromKeyValueArrayTest() {
    $key_value_array = [];
    $key_value_array['foo'] = 'Foo';
    $collection = TokenCollection::createFromKeyValueArray($key_value_array);
    $token = $collection->first();

    $this->assertInstanceOf(Token::class, $token);
    $this->assertSame('foo', $token->token());
    $this->assertSame('Foo', $token->value());
  }

}

final class FooToken implements TokenInterface {

  public function description(): string {
    return '';
  }

  public function token(): string {
    return 'foo';
  }

  public function value(array $context) {
    return 'Foo';
  }

  public function setToken(string $token): TokenInterface {
    return $this;
  }

  public function setValue($value): TokenInterface {
    return $this;
  }

  public function setDescription(string $description): TokenInterface {
    return $this;
  }
}

final class BarToken implements TokenInterface {

  public function description(): string {
    return '';
  }

  public function token(): string {
    return 'bar';
  }

  public function value(array $context) {
    return 'Bar';
  }

  public function setToken(string $token): TokenInterface {
    return $this;
  }

  public function setValue($value): TokenInterface {
    return $this;
  }

  public function setDescription(string $description): TokenInterface {
    return $this;
  }
}
