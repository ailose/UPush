<?php
/**
 * Created by PhpStorm.
 * User: hym
 * Date: 19-1-31
 * Time: 下午1:50
 */

namespace Ailose;
use Ailose\notification\android\AndroidBroadcast;
use Ailose\notification\android\AndroidUnicast;
use Ailose\notification\android\AndroidFilecast;
use Ailose\notification\android\AndroidGroupcast;
use Ailose\notification\android\AndroidCustomizedcast;

class Android extends base {

    function __construct($key, $secret)
    {
        parent::__construct($key, $secret);
    }

    /**
     * @param $title
     * @param $ticker
     * @param $text
     * @param string $after_open
     * @param array $extra_fields
     * @param string $production_mode
     * @return array|mixed
     */
    public function sendBroadcast($title, $ticker, $text, $extra_fields = [], $after_open = 'go_app', $production_mode = 'true') {
        try {
            $brocast = new AndroidBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey",         $this->appkey );
            $brocast->setPredefinedKeyValue("timestamp",      $this->timestamp);
            $brocast->setPredefinedKeyValue("ticker",           $ticker);
            $brocast->setPredefinedKeyValue("title",            $title);
            $brocast->setPredefinedKeyValue("text",             $text);
            $brocast->setPredefinedKeyValue("after_open",       $after_open);
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $brocast->setPredefinedKeyValue("production_mode", "true");
            // [optional]Set extra fields
            if(!empty($extra_fields)) {
                foreach ($extra_fields as $key=>$extra_field) {
                    $brocast->setExtraField($key, $extra_field);
                }
            }

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

    /**
     * @param $push_token
     * @param $title
     * @param $ticker
     * @param $text
     * @param array $extra_fields
     * @param string $after_open
     * @param string $production_mode
     * @return array|mixed
     */
    public function sendUnicast($push_token, $title, $ticker, $text, $extra_fields = [], $after_open = 'go_app', $production_mode = "true") {
        try {
            $unicast = new AndroidUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue("appkey",          $this->appkey);
            $unicast->setPredefinedKeyValue("timestamp",       $this->timestamp);
            // Set your device tokens here
            $unicast->setPredefinedKeyValue("device_tokens",    $push_token);
            $unicast->setPredefinedKeyValue("ticker",           $ticker);
            $unicast->setPredefinedKeyValue("title",            $title);
            $unicast->setPredefinedKeyValue("text",             $text);
            $unicast->setPredefinedKeyValue("after_open",       $after_open);
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $unicast->setPredefinedKeyValue("production_mode", $production_mode);
            if(!empty($extra_fields)) {
                foreach ($extra_fields as $key=>$extra_field) {
                    $unicast->setExtraField($key, $extra_field);
                }
            }
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

    /**
     * @param $title
     * @param $ticker
     * @param $text
     * @param $content
     * @param string $after_open
     * @return array|mixed
     */
    public function sendFilecast($title, $ticker, $text, $content, $after_open = 'go_app') {
        try {
            $filecast = new AndroidFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue("appkey",          $this->appkey);
            $filecast->setPredefinedKeyValue("timestamp",       $this->timestamp);
            $filecast->setPredefinedKeyValue("ticker",           $ticker);
            $filecast->setPredefinedKeyValue("title",            $title);
            $filecast->setPredefinedKeyValue("text",             $text);
            $filecast->setPredefinedKeyValue("after_open",       $after_open);  //go to app
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

    /**
     * @param $filter
     * @param $title
     * @param $ticker
     * @param $text
     * @param string $after_open
     * @param string $production_mode
     * @return array|mixed
     */
    public function sendGroupcast($filter, $title, $ticker, $text, $after_open = 'go_app', $production_mode = "true") {
        try {
//            $filter = 	array(
//                "where" => 	array(
//                    "and" 	=>  array(
//                        array(
//                            "tag" => "test"
//                        ),
//                        array(
//                            "tag" => "Test"
//                        )
//                    )
//                )
//            );

            $groupcast = new AndroidGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $groupcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue("filter",           $filter);
            $groupcast->setPredefinedKeyValue("ticker",           $ticker);
            $groupcast->setPredefinedKeyValue("title",            $title);
            $groupcast->setPredefinedKeyValue("text",             $text);
            $groupcast->setPredefinedKeyValue("after_open",       $after_open);
            // Set 'production_mode' to 'false' if it's a test device.
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

    /**
     * @param $alias
     * @param $alias_type
     * @param $title
     * @param $ticker
     * @param $text
     * @param string $after_open
     * @return array|mixed
     */
    public function sendCustomizedcast($alias, $alias_type, $title, $ticker, $text, $after_open = 'go_app') {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue("alias",            $alias);
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type",       $alias_type);
            $customizedcast->setPredefinedKeyValue("ticker",           $ticker);
            $customizedcast->setPredefinedKeyValue("title",            $title);
            $customizedcast->setPredefinedKeyValue("text",             $text);
            $customizedcast->setPredefinedKeyValue("after_open",       $after_open);
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

    /**
     * @param $alias_type
     * @param $title
     * @param $ticker
     * @param $text
     * @param $content
     * @param string $after_open
     * @return array|mixed
     */
    public function sendCustomizedcastFileId($alias_type, $title, $ticker, $text, $content, $after_open = 'go_app') {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->uploadContents($content);
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type",       $alias_type);
            $customizedcast->setPredefinedKeyValue("ticker",           $ticker);
            $customizedcast->setPredefinedKeyValue("title",            $title);
            $customizedcast->setPredefinedKeyValue("text",             $text);
            $customizedcast->setPredefinedKeyValue("after_open",       $after_open);
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