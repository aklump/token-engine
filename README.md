# Token Engine

A style-independent engine for string token replacement.

Here are three included styles...

| Tokenized String   | Final Output | Style                 |
|--------------------|--------------|-----------------------|
| Hello {{ first }}, | Hello Peter, | TwigStyle             |
| Hello @first,      | Hello Peter, | AtStyle               |
| Hello __first,     | Hello Peter, | DoubleUnderscoreStyle |

Or make your own by implmenting `\AKlump\TokenEngine\TokenStyleInterface`

## Basic Usage

```php
$tokens = \AKlump\TokenEngine\TokenCollection::createFromKeyValueArray([
  'first' => 'Peter',
]);
$replace_tokens = (new \AKlump\TokenEngine\ReplaceTokens($tokens, new \AKlump\TokenEngine\Styles\AtStyle()));

'Welcome Mary Smith,' === $replace_tokens('Hello @first,');
```

## Callable Tokens

```php
// Create a new token collection.
$tokens = new \AKlump\TokenEngine\TokenCollection();

// Create a token with a callable value.
$callable_token = new \AKlump\TokenEngine\Token('first|toUpperCase');
$callable_token->setValue(function (array $context) {

  // Oversimplified, but it makes the point of callables and context.
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

'HEY PETER!' === $shout;
```

## Working with Styles

```php
$string = 'lorem';
$stylized = (new \AKlump\TokenEngine\Helpers\StylizeString(new \AKlump\TokenEngine\Styles\TwigStyle()))($string);
'{{ lorem }}' === $stylized;

$array = ['foo' => 'bar'];
$stylized = (new \AKlump\TokenEngine\Helpers\ArrayStylizeKeys(new \AKlump\TokenEngine\Styles\TwigStyle()))($array);
['{{ foo }}' => 'bar'] === $stylized;

$array = ['foo' => 'bar'];
$stylized = (new \AKlump\TokenEngine\Helpers\ArrayStylizeValues(new \AKlump\TokenEngine\Styles\TwigStyle()))($array);
['foo' => '{{ bar }}'] === $stylized;
```

## More Example Code

This comes from a project's documentation generation.

```php
// Combine two different token collections.
$collection = GetContextTokens::getExampleTokens();
$collection = $collection->merge(GetBudgetTokens::getExampleTokens());

// Sort them by their tokens.
$collection = $collection->sort('token');

// We want to the documentation to show the styled token.
$styler = new \AKlump\TokenEngine\Helpers\StylizeString(new \AKlump\TokenEngine\Styles\AtStyle());

// Iterate on the combined collection and access token properties.
$table_data = [];
foreach ($collection as $token) {
  $table_data[] = [
    'token' => $styler($token->token()),
    'description' => $token->description(),
    'example' => $token->value(),
  ];
}
$table = (new CreateTable())($table_data);
```
