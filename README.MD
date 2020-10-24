### Green Cell Generator

Before running use composer:
```bash
composer install
```

* To run app type:
```bash
php bin/console generate -w 10 -f 1 -t 100 --force
```

* To run tests just type:
```bash
php bin/phpunit
```

Exceptions logged to file:
```
var/log/exceptions.log
```
Can be changed in config files:
```
config/packages/dev/monolog.yaml
```
or
```
config/packages/prod/monolog.yaml
```