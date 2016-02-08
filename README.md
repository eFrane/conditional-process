# Conditional Process

Conditionally run processes. 

## Installation

This package is available on composer. You can install it with
`composer require efrane/conditional-process`.

## Usage

```php
$process = new ConditionalProcess('cat README.md', new FileExists('README.md'));

$process->execute($readmeText);

// $readmeText will contain the contents of README.md if that file exists
```

## License

This package is available under the terms of the MIT license.
