# HTTP Cookie for Google Analytics

Makes Google Analytics use a server side HTTP cookie instead of the default javascript cookie set with document.cookie.

## Background

Browser vendors are increasingly limiting the ability to use and persist cookies set with document.cookie. Among other things, this impacts Google Analytics' ability to identify and recognise e.g. returning users.

## Solution

As of yet, first party cookies that are set in the HTTP header are not affected by steps taken by browser vendors. As such, it's possible to preserve data quality in Google Analytics by using a HTTP cookie. This package does that.

# Installation

You can install the package through [Composer](https://getcomposer.org/):

```
$ composer require analytical42/ga-header-cookie
```

There are no dependencies.

# Usage

By default, you can run the package without any configurations when bootstrapping your application. Simply instantiate the class:

```php
$gaCookie = new \GoogleAnalyticsCookie\Cookie;
```

And that's it!

## Configuration

If required, it's possible to manually set the cookie name and cookie domain when instantiating:

```php
$gaCookie = new \GoogleAnalyticsCookie\Cookie( '_myGaCookieName', 'mydomain.com' );
```

## Default parameters

By default, the package will use Google Analytics' default cookie name (\_ga). In addition, if you don't specify a domain, the package will use the value of [`$_SERVER['HTTP_HOST']`](http://php.net/manual/en/reserved.variables.server.php).

# License

The MIT License (MIT)

Copyright (c) 2019 Phillip Studinski

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.