基于CodeIngiter7.1.3版本开发的一个项目骨架，环境要求php5.6以及以上

本项目只对CodeIngiter做增强，不修改system目录任何代码

# 优化日志
- 在原有日志级别info、error、debug基础上又增加了warn级别
- 公共日志函数支持写warn日志,log_message("warn",$message),自动将日志写入logs/framework目录
- 支持为每条日志写入关键字，便于根据关键字快速过滤日志
- 每个请求的多条日志记录相同的requestId,便于根据requestId快速过滤当次请求的所有日志
- 提供了更友好的日志类,`$message`可以是标量字符串、数字等，也可以是数组
```php
Logger::debug($keywords,$message)
Logger::info($keywords,$message)
Logger::warn($keywords,$message)
Logger::error($keywords,$message)
```
- 调用Logger类写入的日志记录在`logs/app`目录,是我们的业务日志;log_message公共函数写入的日志记录在`logs/framework`目录，这个是系统日志，将两者分开可以，便于日志的管理，以及问题的快速定位
- 日志级别和基础框架一样由`config.php`文件的`log_threshold`管控
```shell
# Logger::warn('warn关键字',"这是错误消息")
634684ab937a2 | WARN | 2022-10-12 11:11:07 | warn关键字 | 这是错误消息
# Logger::warn('error关键字',"error内容")
634684d781b4d | ERROR | 2022-10-12 11:11:51 | error关键字 | error内容
```

# 添加了service层

- 使用方法

在controller里面使用方法`$this->load->service()`
```php
$this->load->service("UserService")
$this->UserService->getUserList();
```

- service文件存储规则

一个service文件就是一个类，文件名和类名一致，通常以Service结尾，跟其他用途的类文件区分开来，如`UserService.php`,service文件存储在`models/service`目录,service类继承自`core/MY_Service`类
```php
// models/UserService.php
class UserService extends MY_Service {

    public function getUserList() {
        // todo something
    }
}
```
# 添加了dao层
个人很难接收对db的操作写在model里面，对db的操作应该写在dao里面更合适一点，由controller调用service，service调用dao层，当然如果项目不复杂，可以直接controller调用dao
- 使用方法

在service或者controller里面使用方法`$this->load->dao()`
```php
$this->load->dao("UserDao")
$this->UserDao->getUserList($where);
```

- dao文件存储规则

一个dao文件也是一个类，文件名和类名一致，通常以Dao结尾，主要目的也是跟其他用途的类文件区分开来，如`UserDao.php`,dao文件存储在`models/dao`目录,dao类继承自`core/MY_Dao`类
```php
// models/UserDao.php
class UserDao extends MY_Dao {

    public function getUserList($where) {
        $query = $this->db->query("YOUR QUERY");
        return $query->result_array();
    }
}
```
# 优化控制器
- 为了跟Service、Dao等用户的文件名规则保持一致，所以controller名以及类名做了调整，文件名为xxxController，action操作名称跟之前一样;
```php
//controllers/HelloController.php
class HelloController extends MY_Controller {

    public function show() {
        //todo something
    }
}
```
注意文件名的改动不影响`config/routes.php`文件的路由配置规则
```php
$route['default_controller'] = 'hello';

$route['home'] = 'hello/index';
```

- MY_Controller控制器提供了`success()`和`error()`两个快捷方法，返回标准json格式(根字段仅仅包括code、message、data三个字段）
```php
<?php
class HelloController extends MY_Controller {
    
    function index() {
        //{"code":0,"data":[1,2,3],"message":"\u83b7\u53d6\u6570\u636e\u6210\u529f"}
        $this->success([1,2,3],'获取数据成功');
    }

    function show() {
        //{"code":404,"data":[],"message":"Id\u4e0d\u5b58\u5728"}
        $this->error(404,'Id不存在');
    }
}
>
```

# 其它推荐
vscode有个插件`PHP intellisense for codeigniter`,可以智能提示codeigniter的方法，包括load的方法、db等，
model、service、dao在load后，可以智能提示load的类的公共方法、属性