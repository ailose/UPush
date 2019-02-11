<?php
/**
 * Created by PhpStorm.
 * User: hym
 * Date: 19-2-11
 * Time: 上午11:15
 */

require_once '../vendor/autoload.php';

use Ailose\Android;
use Ailose\Ios;

$obj = new Android('1', '1');
$obj1 = new Ios('2', '2');
$r = $obj->sendUnicast('1', 'ss', 'ss', 'sss');
$r1 = $obj1->sendUnicast('1', 'ss');
print_r($r);
print_r($r1);