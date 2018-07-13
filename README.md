## cPanel/WHM API PHP
Manage your WHM/cPanel server with this PHP library. Simple to use.

### Installation


### Usage
```php
<?php
require "vendor/autoload.php";

//Build WHM Client
use PreviewTechs\cPanelWHM\WHM\Accounts;
use PreviewTechs\cPanelWHM\WHMClient;

require "vendor/autoload.php";
$c = new WHMClient("WHM_USERNAME","API_TOKEN", "yourwhmserver.com", 2087);
$accounts = new Accounts($c);

var_dump($accounts->searchAccounts());
```