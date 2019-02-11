# upush
you can see doc from `https://dev.umeng.com/sdk_integate/android_push_apidoc#4_1`

友盟sdk推送集成  composer 版本


# Base

Appkey：应用唯一标识。友盟消息推送服务提供的appkey和友盟统计分析平台使用的同一套appkey。

App Master Secret：服务器秘钥，用于服务器端调用API请求时对发送内容做签名验证。

device_token: 友盟消息推送服务对设备的唯一标识。Android的device_token是44位字符串，iOS的device_token是64位。

alias: 开发者自有账号，开发者可以在SDK中调用setAlias(alias, alias_type)接口将alias+alias_type与device_token做绑定，之后开发者就可以根据自有业务逻辑筛选出alias进行消息推送。

单播(unicast): 向指定的设备发送消息。

列播(listcast): 向指定的一批设备发送消息。

广播(broadcast): 向安装该App的所有设备发送消息。

组播(groupcast): 向满足特定条件的设备集合发送消息，例如: "特定版本"、"特定地域"等。

文件播(filecast): 开发者将批量的device_token或者alias存放到文件，通过文件ID进行消息发送。

自定义播(customizedcast): 开发者通过自有的alias进行推送，可以针对单个或者一批alias进行推送，也可以将alias存放到文件进行发送。

通知-Android(notification): 消息送达到用户设备后，由友盟SDK接管处理并在通知栏上显示通知内容。

消息-Android(message): 消息送达到用户设备后，消息内容透传给应用自身进行解析处理。

通知-iOS: 和APNs定义一致。

静默推送-iOS: 和APNs定义一致。

测试模式: 在广播、组播等大规模发送消息的情况下，为了防止开发者误将测试消息大面积发给线上用户，特增加了测试模式。 测试模式下，只会将消息发送给测试设备。测试设备需要到网站上手工添加。

测试模式-Android: Android的测试设备是正式设备的一个子集
测试模式-iOS: iOS的测试模式对应APNs的开发环境(sandbox), 正式模式对应APNs的生产环境(prod)，测试设备和正式设备完全隔离。

签名: 为了保证调用API的请求是合法者发送且参数没有被篡改，需要在调用API时对发送的所有内容进行签名。签名附加在调用地址后面，签名的计算方式参见附录K。
推送类型: 单播(unicast)、列播(listcast)、自定义播(customizedcast且不带file_id)统称为单播类型消息，Web后台不会展示此类消息详细信息，仅展示前一天的汇总数据；广播(broadcast)、文件播(filecast)、组播(groupcast)、自定义播(customizedcast且file_id不为空)统称为任务类型消息，任务支持查询、撤销操作，Web后台会展示此类消息详细信息。

# How to Use

```
use Ailose\Android;
$obj = new Android('your key', 'your secret');
$r = $obj->sendUnicast('push_token', 'title', 'ticker', 'text');

```
