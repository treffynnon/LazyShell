# LazyShell

A lazy way to make shell commands from PHP - handy for use from a
REPL for instance. It uses my [CmdWrap](https://github.com/treffynnon/CmdWrap)
library underneath to provide the command building and process runners.

## Installation

```bash
composer require treffynnon/lazyshell
```

## Example

```php
Sh::date("'+%Y-%m-%d'"); // date '+%Y-%m-%d'
$listing = Sh::ls('-lkha'); // ls -lkha
```

You can also modify the output by passing in a lambda or closure.

```php
Sh::date("'+%Y-%m-%d'", function ($line) {
    return str_replace(date('Y'), '', $line);
})
```

The function is called against each line of output from the command.

## Safety

Note that by default arguments will be passed in raw so you need to sanitise
them before passing them to LazyShell. If you need escaping then you can
pass in any of the [CmdWrap types](https://github.com/treffynnon/CmdWrap#available-command-line-types)
instead. I still would not allow user supplied variables go directly into commands
though.

```php
Sh::date(new Parameter('+%Y-%m-%d')); // date '+%Y-%m-%d'
```

## Tests

Integration testing with phpunit and the code is also linted with `php -l`, phpcs and phpcpd. To run the
tests you can use the following composer command:

```bash
composer test
```

## Licence

BSD 2 clause licence - see LICENCE.md.
