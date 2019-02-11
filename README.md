# upush
you can see doc from `https://dev.umeng.com/sdk_integate/android_push_apidoc#4_1`

# How to Use

```
use Ailose\Android;
$obj = new Android('your key', 'your secret');
$r = $obj->sendUnicast('push_token', 'title', 'ticker', 'text');

```
