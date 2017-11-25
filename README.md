# wx-nba-api
wx-nba-api 是为nba小程序[wx-nba](https://github.com/ecitlm/wx-nba)提供的api接口、抓取其他网站NBA新闻直播、球队、球员数据抓取整理
* 拦截器，
* 接口签名校验、
接口服务列表
[在线地址：](http://wxapp.it919.cn/wx/listAllApis.php)
http://wxapp.it919.cn/wx/listAllApis.php
![图片](https://dn-coding-net-production-pp.qbox.me/2e4887a6-898c-42b9-8662-6657b4bcf1ea.png)


#### 关于接口签名问题

* 接口请求签名，客户端与服务端约定好一个`appkey`
* 排除签名参数（sign和接口的service）
* 将剩下的全部参数和appkey，按参数名字进行字典升序排序
* 将排序好的参数，全部用字符串拼接起来
* 进行md5运算，生成签名`sign`

`appkey`可以在`Config/sys.php`中配置
```
  'appkey' => '你设定的秘钥',
```
__关于接口的时间戳参数问题__

`timestamp` 用来保存接口一次请求的时效性,时间戳参数传递客户端当前的时间戳给服务端、服务端将该时间戳与服务器的时间进行对比,当两个时间戳的差距大于300S时，
提示接口请求超时,以保证其他人抓取改接口能重复使用

框架通过过滤器可以设置签名 sign 白名单、一些不需要设置签名的接口可以在`app.php`中配置
```php
<?php
return array(

    /**
     * 应用接口层的统一参数说
     */
    'apiCommonRules' => array(
        'sign' => array('name' => 'sign', 'require' => true),
        'timestamp' => array('name'=>'timestamp', 'type'=>'string', 'require'=>false, 'desc'=>'时间戳参数')
    ),
    /**
     * 不需要带签名的接口
     */
    'apiFilterRules' => array(
        'Index.index',
        'Nba.img',
        'Nba.website',
    ),

    /**
     * 需要带Token的接口
     */
    'apiTokenRules' => array(
        'User.center',
        'User.wallet'
    ),
);

```