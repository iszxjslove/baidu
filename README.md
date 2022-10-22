## 百度开放平台 SDK

### 安装
```shell
composer require iszxjslove/baidu
```

### 配置
- 方式一 [例子](example/baidu.php)
  - ThinkPHP、laveral等有config方法的项目中创建baidu.php配置文件

- 方式二 [例子](example/.env_example)
  - .env文件中添加配置 
- 方式三
  - 参数传入,具体看每个实现功能里的说明
  
  ```injectablephp
  $translate = new \Yufu\Baidu\translate\Universal($appid, $secret)
  ```

### 实现功能

- 百度翻译
  - [通用翻译](/doc/translate/universal.md)


### 