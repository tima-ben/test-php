# test-salesfloor

Test for Salesfloor company on post sr. PHP Developer

Task description you can read [here](./DESCRIPTION.md)

Documentation you can see **./docs/api/index.html** (_note:_ open this file on web-browser)

## Instalation

Checkout project

```bash
git clone https://github.com/tima-ben/test-salesfloor.git
```

Go to project directory and run composer install

``` bah
composer install
```

## Run project

You can run project by 3 different way.

Auto mode, get all information from file

```bash
php src/robots.php input.txt
```

Manual mode, get all information from console

```bash
php src/robots.php 
```

Mix mode.

```bash
php src/robots.php <input.txt
```

## For testing execute next commands in project directory

Test main script __robots.php__

```bash
vendor/bin/phpunit tests/RobotsTest.php
```

Test class __BlocksWorld__

```bash
vendor/bin/phpunit tests/BlocksWorldTest.php
```

## Fibonacci sequence

For check Fibonacci sequence execute next command

```bash
php src/fibonacci.php
```

This command show runtime function with and without recursion.

You can make conclusion yourself. ;)
