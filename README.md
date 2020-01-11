<h1 align="left"><a href="#">ByteDance SDK</a></h1>

📦 It is probably the best SDK in the world for developing Wechat App.


## Requirement

1. PHP >= 7.1
2. **[Composer](https://getcomposer.org/)**
3. openssl 拓展


## Installation

```shell
$ composer require "otkurbiz/bytedance" -vvv
```

## Usage

基本使用（以服务端为例）:

```php
<?php

use EasyWeChat\Factory;

$options = [
    'app_id'    => 'wx3cf01239eb0exxx',
    'app_secret'    => 'f1c242f4f28f735d4687abb469072xxx',
    // ...
];

$app = Factory::make($options);

$session = $app->auth->session($code);
```


## Documentation

Coming soon

## Integration

[Laravel 5 拓展包: otkurbiz/laravel-bytedance](https://github.com/otkurbiz/laravel-bytedance)

## Contributors


## License

MIT

## Special Thanks
[@overtrue](https://github.com/overtrue)

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fotkurbiz%2Fbytedance.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fovertrue%2Fwechat?ref=badge_large)
