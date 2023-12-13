<?php

namespace AKlump\TokenEngine\Tests\Unit\Helpers;

use AKlump\TokenEngine\Helpers\CreateExamples;
use AKlump\TokenEngine\Token;
use AKlump\TokenEngine\TokenCollection;
use AKlump\TokenEngine\TokenInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\TokenEngine\Helpers\CreateExamples
 * @uses   \AKlump\TokenEngine\Token
 * @uses   \AKlump\TokenEngine\TokenCollection
 */
class CreateExamplesTest extends TestCase {

  public function testInvokeWithoutCallbackWorksAsExpected() {
    $collection = new TokenCollection();
    $collection->add(new Token('foo'));
    $collection->add(new Token('bar'));

    $examples = (new CreateExamples())($collection);
    $this->assertNotSame($examples, $collection);
    $this->assertSame($examples->toKeyValueArray(), $collection->toKeyValueArray());
  }

  public function testInvoke() {
    $collection = new TokenCollection();
    $collection->add(new Token('first_name'));
    $collection->add(new Token('last_name'));

    $examples = (new CreateExamples())($collection, function (TokenInterface $token) {
      switch ($token->token()) {
        case 'first_name':
          $token
            ->setValue('Mark')
            ->setDescription('Their first name.');
          break;

        case 'last_name':
          $token
            ->setValue('Smith')
            ->setDescription('Their last name.');
          break;
      }
    });

    $this->assertCount(2, $examples);

    $this->assertSame('first_name', $examples[0]->token());
    $this->assertSame('Mark', $examples[0]->value());
    $this->assertSame('Their first name.', $examples[0]->description());

    $this->assertSame('last_name', $examples[1]->token());
    $this->assertSame('Smith', $examples[1]->value());
    $this->assertSame('Their last name.', $examples[1]->description());
  }

}
