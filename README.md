## cPanel/WHM API PHP
Manage your WHM/cPanel server with this PHP library. Simple to use. With this PHP library, you can manage your cPanel/WHM server.

[![License](https://img.shields.io/packagist/l/previewtechs/cpanel-whm-api.svg)](https://github.com/PreviewTechnologies/cpanel-whm-api/blob/master/LICENSE)
[![Build Status](https://api.travis-ci.org/PreviewTechnologies/cpanel-whm-api.svg?branch=master)](https://travis-ci.org/PreviewTechnologies/cpanel-whm-api)
[![Code Coverage](https://scrutinizer-ci.com/g/PreviewTechnologies/cpanel-whm-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PreviewTechnologies/cpanel-whm-api/?branch=master)
[![Code Quality](https://scrutinizer-ci.com/g/PreviewTechnologies/cpanel-whm-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PreviewTechnologies/cpanel-whm-api/?branch=master)
[![Code Quality](https://scrutinizer-ci.com/g/PreviewTechnologies/cpanel-whm-api/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/g/PreviewTechnologies/cpanel-whm-api/?branch=master)

### Installation

You can install this library with composer.

```bash
composer require previewtechs/cpanel-whm-api:dev-master
```

### Usage
```php
<?php
require "vendor/autoload.php";

//Build WHM Client
use PreviewTechs\cPanelWHM\WHM\Accounts;
use PreviewTechs\cPanelWHM\WHMClient;

require "vendor/autoload.php";
$whmClient = new WHMClient("WHM_USERNAME","API_TOKEN", "yourwhmserver.com", 2087);
$accounts = new Accounts($whmClient);

var_dump($accounts->searchAccounts());
```

#### WHM Client

To access and use WHM related functionality you must need to build WHM client with configuration
and credentials.

To configure your WHM client, you must provide your WHM username (you use to login into your WHM panel) and API Token. 

If you have an API token you can use that if proper permissions are configured, otherwise
you can create a new API token from your WHM.

Create API token from https://your-whm-server:2087/cpsessxxxxxx/scripts7/apitokens/home

Learn more about WHM API Token from [https://documentation.cpanel.net/display/64Docs/Manage+API+Tokens](https://documentation.cpanel.net/display/64Docs/Manage+API+Tokens)
```php
<?php
use PreviewTechs\cPanelWHM\WHMClient;
$whmClient = new WHMClient("WHM_USERNAME","API_TOKEN", "yourwhmserver.com", 2087);
```

### Available Functionality
- WHM
  - Accounts
    - searchAccounts (List of all accounts)
    - getDetails (Details of a specific account)
    - create (Create a new account)
    - availableFunctions (List of API functions available for current authenticated user)
    - userDomainDetails (Get a hosted domain details)
    - changeDiskSpaceQuota (Modify an user's disk space quota)
    - forcePasswordChange (Force user to change their password at their next login)
    - getDomains (List of domains exists in the server)
    - hasDigestAuth (Digest auth is enabled or disabled)
    - hasMyCnfInHomeDirectory (.my.cnf file exists in user's home directory or not)
    - limitBandwidth (Modify bandwidth limit)
    - getUsers (List of all users in server)
    - getLockedAccounts (List of all locked accounts)
    - getSuspendedAccounts (List of all suspended accounts)
    - createUserSession()
    - changePlan()    

### Contibutions
You are always welcome to contribute in this library.

See our [list of contributors](https://github.com/PreviewTechnologies/cpanel-whm-api/graphs/contributors)

### Issues/Bug Reports
Please [create an issue or report a bug](https://github.com/PreviewTechnologies/cpanel-whm-api/issues/new) in this GitHub repository and we will be
happy to look into that.

### License

The MIT License (MIT)

Copyright (c) 2014 Domain Reseller API

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
