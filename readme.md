# Gammu SMS Api

[![Build Status](https://travis-ci.org/kristiandrucker/gammuApi.svg?branch=master)](https://travis-ci.org/kristiandrucker/gammuApi)
[![Circle CI](https://img.shields.io/circleci/project/BrightFlair/PHP.Gt.svg)](https://styleci.io/repos/66146220)
[![Total downloads](https://img.shields.io/github/downloads/kristiandrucker/gammuApi/total.svg)](https://github.com/kristiandrucker/gammuApi)

Gammu SMS Api with queue. You can send messages via this api and it will send it via your gammu sms server. This needs to be deployed on a gammu sms server.

## Installation
``` bash
$ php artisan install
```

## Documentation

#### Creating auth key
``` bash
$ php artisan key:create
```

It will return your auth key. Keep it safe.

#### Revoking auth key
``` bash
$ php artisan key:revoke yourAuthKey
```

#### Calling the API
``` bash
$ curl -X POST http://gammu.api/send/sms?key=yourAuthKey&to=telNumberToSendTo&message=Your message to send to client
```

It will return `Sent message to: telNumberToSendTo`

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Kristian Drucker at kristian@rolmi.sk. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
