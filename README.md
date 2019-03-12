# HTTP Cookie for Google Analytics

Makes Google Analytics use a server side HTTP cookie instead of the default javascript cookie set with document.cookie.

## Background

Browser vendors are increasingly limiting the ability to use and persist cookies set with document.cookie. Among other things, this impacts Google Analytics' ability to identify and recognise e.g. returning users.

## Solution

As of yet, first party cookies that are set in the HTTP header are not affected by steps taken by browser vendors. As such, it's possible to preserve data quality in Google Analytics by using a HTTP cookie. This package does that.

The library currently works by storing the Client ID in a custom HTTP Only cookie (`_ga_storage`). Whenever a user visits the website, the library first checks this cookie for a Client ID. If it's not found, a Client ID is searched for in the default GA cookie (`_ga`), and if this isn't found either, a new Client ID is generated.

The Client ID is then stored in the `_ga_storage` cookie with a two year expiration time. Secondly, the Client ID is also written to the `_ga` cookie which is then used by Google Analytics.

I have opted for this solution since just setting the `_ga` cookie with PHP does not seem to work as intended. The cookie will be set correctly, but once the Google Analytics library (analytics.js) loads, the cookie is overwritten with document.cookie. Please contribute, if you know how this can be avoided.

# Installation

You can install the package through [Composer](https://getcomposer.org/):

```
$ composer require analytical42/googleanalyticscookkie
```

There are no dependencies.

# Usage

By default, you can run the package without any configurations when bootstrapping your application. Simply instantiate the class:

```php
$gaCookie = new Analytical42\GoogleAnalyticsCookie\Cookie;
```

And that's it!

## Configuration

If required, it's possible to manually set the cookie name and cookie domain when instantiating:

```php
$gaCookie = new Analytical42\GoogleAnalyticsCookie\Cookie( '_myGaCookieName', 'mydomain.com', true );
```

## Default parameters

By default, the package will use Google Analytics' default cookie name (\_ga). In addition, if you don't specify a domain, the package will use the value of [`$_SERVER['HTTP_HOST']`](http://php.net/manual/en/reserved.variables.server.php).

The last option indicates whether or not to write a secure cookie (secure = `true`, unsecure = `false`).

# License

The MIT License (MIT)

Copyright (c) 2019 Phillip Studinski

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
