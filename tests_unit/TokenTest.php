<?php

namespace AKlump\TokenEngine\Tests\Unit;

use AKlump\TokenEngine\Token;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \AKlump\TokenEngine\Token
 */
class TokenTest extends TestCase {

  public function testStaticCreateMethod() {
    $token = Token::create('name', 'Peter', 'The first name of the account.');
    $this->assertSame('name', $token->token());
    $this->assertSame('Peter', $token->value());
    $this->assertSame('The first name of the account.', $token->description());
  }

  public function testConstructor() {
    $token = new Token('name', 'Peter', 'The first name of the account.');
    $this->assertSame('name', $token->token());
    $this->assertSame('Peter', $token->value());
    $this->assertSame('The first name of the account.', $token->description());
  }

  public function testValueMethods() {
    $foo = (new Token('bar'))->setValue('baz');
    $this->assertSame('baz', $foo->value());
  }

  public function testDescriptionMethod() {
    $foo = (new Token('bar'))->setDescription('Lorem');
    $this->assertSame('Lorem', $foo->description());
  }

  public function testTokenMethods() {
    $foo = new Token('bar');
    $this->assertSame('bar', $foo->token());
    $foo->setToken('november');
    $this->assertSame('november', $foo->token());
  }

  public function testValueCallableReceivesTokenAsLastArgument() {
    $token = (new Token('foo'))->setValue(function () {
      $args = func_get_args();

      return array_pop($args);
    });
    $this->assertSame($token, $token->value());
  }

  public function testValueCallableReceivesContext() {
    $token = (new Token('foo'))->setValue(function (array $context) {
      return $context['time'];
    });
    $context = ['time' => time()];
    $this->assertSame($context['time'], $token->value($context));
  }

  public function testStringableValueObjectWorks() {
    $token = (new Token('foo'))->setValue(new TestableValueObject());
    $this->assertSame('foo', $token->value());
  }

  public function testSetValueWithNonStringableObjectThrows() {
    $this->expectException(\InvalidArgumentException::class);
    (new Token('foo'))->setValue(new stdClass());
  }

  public function testSetValueWithArrayThrows() {
    $this->expectException(\InvalidArgumentException::class);
    (new Token('foo'))->setValue([]);
  }

  public function testCanInstantiateAndSetDescriptionAndExample() {
    $definition = (new Token('foo'))
      ->setDescription('Lorem ipsum.')
      ->setValue('alpha');
    $this->assertInstanceOf(Token::class, $definition);
  }

}

final class TestableValueObject {

  public function __toString() {
    return 'foo';
  }

}
