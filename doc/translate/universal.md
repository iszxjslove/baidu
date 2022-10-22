## 百度开放平台 SDK

> 翻译 - [通用翻译](https://api.fanyi.baidu.com/doc/21)


- 类
```injectablephp
use \Yufu\Baidu\translate\Universal
```
- 属性 [看注释](src/translate/Universal.php)
- 方法
  - request

<table>
<thead>
<tr>
<th>参数</th><th>类型</th><th>必填</th><th>描述</th>
</tr>
</thead>
<tbody>
<tr>
<td>$query</td><td>string</td><td>是</td><td>需要翻译的文字</td>
</tr>
<tr>
<td>$to</td><td>string</td><td>是</td><td>翻译目标语言，不可设置为auto</td>
</tr>
<tr>
<td>$from</td><td>string</td><td>否</td><td>翻译源语言，可设置为auto</td>
</tr>
</tbody>
</table>

- 例子
```injectablephp
$translate = new \Yufu\Baidu\translate\Universal();
$ret = $translate->request("这是一段要翻译的文字！","en","auto");
if(!$ret){
    exit($translate->response->error_code);
}
var_dump($ret);
```