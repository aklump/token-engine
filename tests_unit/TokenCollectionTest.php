<?php

namespace AKlump\TokenEngine\Tests\Unit;

use AKlump\TokenEngine\Token;
use AKlump\TokenEngine\TokenCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\TokenCollection
 * @uses   \AKlump\TokenEngine\Token
 */
class TokenCollectionTest extends TestCase {

  public function testMapWorksAsExpected() {
    $collection = new TokenCollection();
    $collection->add(new Token('zulu'));
    $mapped = $collection->map(fn(Token $token) => $token->setValue('Zoo Lou'));
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

final class FooToken implements \AKlump\TokenEngine\TokenInterface {

  public function description(): string {
    return '';
  }

  public function token(): string {
    return 'foo';
  }

  public function value(array $context) {
    return 'Foo';
  }

}

final class BarToken implements \AKlump\TokenEngine\TokenInterface {

  public function description(): string {
    return '';
  }

  public function token(): string {
    return 'bar';
  }

  public function value(array $context) {
    return 'Bar';
  }

}
