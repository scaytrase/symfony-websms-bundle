# symfony-websms-bundle

[![Latest Stable Version](https://poser.pugx.org/scaytrase/symfony-websms-bundle/v/stable.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle) [![Total Downloads](https://poser.pugx.org/scaytrase/symfony-websms-bundle/downloads.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle) [![Latest Unstable Version](https://poser.pugx.org/scaytrase/symfony-websms-bundle/v/unstable.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle) [![License](https://poser.pugx.org/scaytrase/symfony-websms-bundle/license.svg)](https://packagist.org/packages/scaytrase/symfony-websms-bundle)


[![Monthly Downloads](https://poser.pugx.org/scaytrase/symfony-websms-bundle/d/monthly.png)](https://packagist.org/packages/scaytrase/symfony-websms-bundle)
[![Daily Downloads](https://poser.pugx.org/scaytrase/symfony-websms-bundle/d/daily.png)](https://packagist.org/packages/scaytrase/symfony-websms-bundle)

This Symfony2 bundle implementation of [scaytrase/symfony-sms-interface](https://github.com/scaytrase/symfony-sms-interface) for [WebSMS](http://www.websms.ru/) sending service

## Current features

- Sending one sms per packet (no mass sending supported)
- Ability to disable delivery via config for testing purposes
- Ability to force redirect messages for testing purposes

## Installation

Installation is available via Composer

### composer.json

```
require: "scaytrase/symfony-websms-bundle": "~1.2.0"
```

### app/AppKernel.php

update your kernel bundle requirements as follows:
```
$bundles = array(
    ....
    new ScayTrase\Utils\WebSMSBundle\WebSMSBundle(),
    ....
    );
```

