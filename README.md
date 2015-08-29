# symfony-websms-bridge

[![Latest Stable Version](https://poser.pugx.org/scaytrase/symfony-websms-bundle/v/stable.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle) [![Total Downloads](https://poser.pugx.org/scaytrase/symfony-websms-bundle/downloads.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle) [![Latest Unstable Version](https://poser.pugx.org/scaytrase/symfony-websms-bundle/v/unstable.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle) [![License](https://poser.pugx.org/scaytrase/symfony-websms-bundle/license.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle)


[![Monthly Downloads](https://poser.pugx.org/scaytrase/symfony-websms-bundle/d/monthly.png)](https://packagist.org/packages/scaytrase/symfony-websms-bundle)
[![Daily Downloads](https://poser.pugx.org/scaytrase/symfony-websms-bundle/d/daily.png)](https://packagist.org/packages/scaytrase/symfony-websms-bundle)

This is the bridge implementing a web transport for [scaytrase/symfony-sms-interface](https://github.com/scaytrase/symfony-sms-interface) for [WebSMS](http://www.websms.ru/) sending service with [this bindings](https://github.com/scaytrase/websms-php)

## Features

### Available
- [x] Single message sending
- [x] Http(Form) and JSON drivers
- [x] Balance could be extracted from connection after each send

### Planned
- [ ] Bulk message sending
- [ ] Sender alias (not supported in the library at the moment)

## Installation

Bundle could be installed via composer

### composer.json

```bash
composer require scaytrase/symfony-websms-bundle:~1.0
```

### app/AppKernel.php

Enable the bundle by including it into your application kernel (`AppKernel.php`):

```php
$bundles = array(
    //....
    new ScayTrase\Utils\WebSMSBundle\WebSMSBundle(),
    //....
    );
```

## Configuration

For now bundle own only essential properties from the underlying library. They could be configured as following (example and default values):

```yaml
web_sms:
    connection:
        login:  null # Login is required to send messages.
        secret: null # Tech secret or account password (both work) is required to send messages
        mode: 0 # 0 is for production mode. 1 is for testing mode (valid credentials required). -1 is for debug purpose (credentials not needed, sending does not occures, valid credentials not required)
```
