# Benchmark Module
[![Build Status](https://github.com/spryker-sdk/benchmark/workflows/CI/badge.svg?branch=master)](https://github.com/spryker-sdk/benchmark/actions?query=workflow%3ACI+branch%3Amaster)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

This module allows to test the performance and response time of individual endpoints. The module allows to create your own tests and run them.

## Installation

```
composer require --dev spryker-sdk/benchmark
```


## Usage

### How to use in Spryker projects

This module provides a convenience command:
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
