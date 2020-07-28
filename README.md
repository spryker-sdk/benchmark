# Benchmark Module
[![Build Status](https://travis-ci.org/spryker-sdk/benchmark.svg?branch=master)](https://travis-ci.org/spryker-sdk/composer-constrainer)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

This module allows to test the performance and response time of individual endpoints. The module allows to create your own tests and run them.

## Installation

```
composer require --dev spryker-sdk/benchmark
```


## Usage

### How to use in Spryker projects
Make sure you include the benchmark as `require-dev` dependency:
```
composer require --dev spryker-sdk/benchmark
```

The Development bundle provides a convenience command:
```
console benchmark:run
```

Path to the directory with tests can be specified by option `path`:
```
console benchmark:run --path tests/Benchmark/Glue
```

The benchmark runner can override the number of revolutions and iterations which will be executed:
```
console benchmark:run --iterations=10 --revs=1000
```
