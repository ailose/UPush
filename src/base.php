<?php
/**
 * Created by PhpStorm.
 * User: hym
 * Date: 19-2-11
 * Time: 上午10:18
 */
namespace Ailose;

abstract class base {

    protected $appkey = null;
    protected $appMasterSecret = null;
    protected $timestamp = null;

    function __construct($key, $secret) {
        $this->appkey = $key;
        $this->appMasterSecret = $secret;
        $this->timestamp = strval(time());
    }
}