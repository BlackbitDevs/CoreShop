![CoreShop](etc/logo.png)

---

**CoreShop - Pimcore eCommerce**

[![Join the chat at https://gitter.im/coreshop/coreshop](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/coreshop/coreshop?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
![Behat UI Tests](https://github.com/coreshop/CoreShop/workflows/PHP%20Stan/badge.svg)
![Behat UI Tests](https://github.com/coreshop/CoreShop/workflows/Behat%20UI/badge.svg)
![Behat UI Tests](https://github.com/coreshop/CoreShop/workflows/Behat/badge.svg)
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat)](LICENSE.md)
[![Latest Pre-Release](https://img.shields.io/packagist/vpre/coreshop/core-shop.svg)](https://www.packagist.org/packages/coreshop/core-shop)

[CoreShop](https://www.coreshop.org) is a eCommerce Platform for [Pimcore](http://www.pimcore.org).

![CoreShop Interface](docs/img/screenshot5.png)

# Requirements 
 - Pimcore `^10.5`

# Installation
 - Allow dev version to be installed:
   ```
   composer config "minimum-stability" "dev"
   composer config "prefer-stable" "true"
   ```
 - Install with composer 
   ```
   composer require coreshop/core-shop:^3.0
   ```
 - Run enable Bundle command
   ```
   php bin/console pimcore:bundle:enable CoreShopCoreBundle
   ```
 - Run Install Command
   ```
   php bin/console coreshop:install
   ```
 - Optional: Install Demo Data 
   ```
   php bin/console coreshop:install:demo
   ```

# Further Information
 - [Website](https://www.coreshop.org)
 - [Documentation](https://docs.coreshop.org/latest)
 - [Pimcore Forum](https://talk.pimcore.org)
 - [Help translate CoreShop](https://crowdin.com/project/coreshop)

# Demo
You can see a running demo here [CoreShop 3.x Demo](https://demox.coreshop.org)

**Backend Credentials**

```
Admin: https://demox.coreshop.org/admin

Username: admin
Password: coreshop
```

## Running Tests Locally
### Psalm
```
vendor/bin/psalm
```

### PHPStan
```
SYMFONY_ENV=test vendor/bin/phpstan analyse -c phpstan.neon src -l 3 --memory-limit=-1
```

### BEHAT Domain
```
CORESHOP_SKIP_DB_SETUP=1 PIMCORE_TEST_DB_DSN=mysql://root:ROOT@coreshop-3-mariadb/coreshop2___behat vendor/bin/behat -c behat.yml.dist -p default
```

### BEHAT UI
```
vendor/bin/bdi detect drivers

# Install Pimcore and CoreShop in Test Env
APP_ENV=test PIMCORE_TEST_DB_DSN=mysql://root:ROOT@coreshop-3-mariadb/coreshop2___behat PIMCORE_INSTALL_ADMIN_USERNAME=admin PIMCORE_INSTALL_ADMIN_PASSWORD=admin PIMCORE_INSTALL_MYSQL_HOST_SOCKET=coreshop-3-mariadb PIMCORE_INSTALL_MYSQL_USERNAME=root PIMCORE_INSTALL_MYSQL_PASSWORD=ROOT PIMCORE_INSTALL_MYSQL_DATABASE=coreshop2___behat PIMCORE_INSTALL_MYSQL_PORT=3306 PIMCORE_KERNEL_CLASS=Kernel vendor/bin/pimcore-install --ignore-existing-config --env=test --skip-database-config
APP_ENV=test PIMCORE_CLASS_DIRECTORY=var/tmp/behat/var/classes PIMCORE_TEST_DB_DSN=mysql://root:ROOT@coreshop-3-mariadb/coreshop2___behat bin/console coreshop:install

# OUTSIDE CONTAINER
# Run Symfony Server
APP_ENV=test PIMCORE_TEST_DB_DSN=mysql://root:ROOT@127.0.0.1:3306/coreshop2___behat symfony server:start --port=9080 --dir=public --no-tls

# Run Behat
CORESHOP_SKIP_DB_SETUP=1 PANTHER_EXTERNAL_BASE_URI=http://127.0.0.1:9080/index_test.php PANTHER_NO_HEADLESS=0 PIMCORE_TEST_DB_DSN=mysql://root:ROOT@127.0.0.1:3306/coreshop2___behat php -d memory_limit=-1 vendor/bin/behat -c behat.yml.dist -p ui -vvv 
```

## Copyright and license 
Copyright: [CoreShop GmbH](https://www.coreshop.org)
For licensing details please visit [LICENSE.md](LICENSE.md) 

## Screenshots
![CoreShop Interface](docs/img/screenshot5-2.png)
![CoreShop Interface](docs/img/screenshot5-3.png)
