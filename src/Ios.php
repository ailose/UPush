<?php
/**
 * Created by PhpStorm.
 * User: hym
 * Date: 19-1-31
 * Time: 下午1:50
 */

namespace Ailose;
use Ailose\notification\ios\IOSBroadcast;
use Ailose\notification\ios\IOSFilecast;
use Ailose\notification\ios\IOSUnicast;
use Ailose\notification\ios\IOSGroupcast;
use Ailose\notification\ios\IOSCustomizedcast;

class Ios extends base {

    function __construct($key, $secret)
    {
        parent::__construct($key, $secret);
    }

    public function sendBroadcast($alert, $customizedField = ['key'=>'test', 'value'=>'helloworld'], $badge = 0, $sound = "chime", $production_mode = 'true') {
        try {
            $brocast = new IOSBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey",           $this->appkey);
            $brocast->setPredefinedKeyValue("timestamp",        $this->timestamp);

            $brocast->setPredefinedKeyValue("alert", $alert);
            $brocast->setPredefinedKeyValue("badge", $badge);
            $brocast->setPredefinedKeyValue("sound", $sound);
            // Set 'production_mode' to 'true' if your app is under production mode
            $brocast->setPredefinedKeyValue("production_mode", $production_mode);
            // Set customized fields
            $brocast->setCustomizedField($customizedField['key'], $customizedField['value']);

            $result = $brocast->send();
            return $result;
        } catch (\Exception $e) {
            return [
                'ret'=>'FAIL',
                'data'=>[
                    'error_msg'=>$e->getMessage(),
                    'error_code'=> -1,
                ]
            ];
        }
    }

    public function sendUnicast($push_token, $alert, $customizedField = ['key'=>'test', 'value'=>'helloworld'], $badge = 0, $sound = "chime", $production_mode = "true") {
        try {
            $unicast = new IOSUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue("appkey",           $this->appkey);
            $unicast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // Set your device tokens here
            $unicast->setPredefinedKeyValue("device_tokens",    $push_token);
            $unicast->setPredefinedKeyValue("alert", $alert);
            $unicast->setPredefinedKeyValue("badge", $badge);
            $unicast->setPredefinedKeyValue("sound", $sound);
            // Set 'production_mode' to 'true' if your app is under production mode
            $unicast->setPredefinedKeyValue("production_mode", $production_mode);
            // Set customized fields
            $unicast->setCustomizedField($customizedField['key'], $customizedField['value']);
            $result = $unicast->send();
            return $result;
        } catch (\Exception $e) {
            return [
                'ret'=>'FAIL',
                'data'=>[
                    'error_msg'=>$e->getMessage(),
                    'error_code'=> -1,
                ]
            ];
        }
    }

    public function sendFilecast($content, $alert, $badge = 0, $sound = "chime", $production_mode = "true") {
        try {
            $filecast = new IOSFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue("appkey",           $this->appkey);
            $filecast->setPredefinedKeyValue("timestamp",        $this->timestamp);

            $filecast->setPredefinedKeyValue("alert", $alert);
            $filecast->setPredefinedKeyValue("badge", $badge);
            $filecast->setPredefinedKeyValue("sound", $sound);
            $filecast->setPredefinedKeyValue("production_mode", $production_mode);
            // print("Uploading file contents, please wait...\r\n");
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents($content);
            //  print("Sending filecast notification, please wait...\r\n");
            $result = $filecast->send();
            return $result;
        } catch (\Exception $e) {
            return [
                'ret'=>'FAIL',
                'data'=>[
                    'error_msg'=>$e->getMessage(),
                    'error_code'=> -1,
                ]
            ];
        }
    }

    public function sendGroupcast($filter,  $alert, $badge = 0, $sound = "chime", $production_mode = "true") {
        try {
            $groupcast = new IOSGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $groupcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue("filter",           $filter);
            $groupcast->setPredefinedKeyValue("alert", $alert);
            $groupcast->setPredefinedKeyValue("badge", $badge);
            $groupcast->setPredefinedKeyValue("sound", $sound);
            // Set 'production_mode' to 'true' if your app is under production mode
            // For how to register a test device, please see the developer doc.
            $groupcast->setPredefinedKeyValue("production_mode", $production_mode);
            $result = $groupcast->send();
            return $result;
        } catch (\Exception $e) {
            return [
                'ret'=>'FAIL',
                'data'=>[
                    'error_msg'=>$e->getMessage(),
                    'error_code'=> -1,
                ]
            ];
        }
    }

    public function sendCustomizedcast($alert, $alias, $alias_type, $badge = 0, $sound = "chime", $production_mode = "true") {
        try {
            $customizedcast = new IOSCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);

            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue("alias", $alias);
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type", $alias_type);
            $customizedcast->setPredefinedKeyValue("alert", $alert);
            $customizedcast->setPredefinedKeyValue("badge", $badge);
            $customizedcast->setPredefinedKeyValue("sound", $sound);
            $customizedcast->setPredefinedKeyValue("production_mode", $production_mode);
            $result = $customizedcast->send();
            return $result;
        } catch (\Exception $e) {
            return [
                'ret'=>'FAIL',
                'data'=>[
                    'error_msg'=>$e->getMessage(),
                    'error_code'=> -1,
                ]
            ];
        }
    }
}