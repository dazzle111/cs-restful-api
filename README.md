### Xiyou Linux Group Collaboration System(CS)

#### RESTful API

西邮Linux兴趣小组内部交流平台WEB应用。

本项目只包含由laravel框架构建的RESTful API部分，WEB应用部分请查看[cs-angular-app](https://github.com/xiyou-linuxer/cs-angular-app),

如需查看API文档，请查看[API WIKI](https://github.com/xiyou-linuxer/cs-xiyoulinux/WIKI/API)

线上地址：http://api.xiyoulinux.org

[![Build Status](https://travis-ci.org/xiyou-linuxer/cs-restful-api.svg?branch=master)](https://travis-ci.org/xiyou-linuxer/cs-restful-api)

#### 开发指南

1. **环境搭建**

  ```
  PHP >= 5.5.9 
    - OpenSSL PHP 扩展
    - PDO PHP 扩展
    - Mbstring PHP 扩展
    - Tokenizer PHP 扩展
  Nginx >= 1.9.1
  ```

1. **环境配置**

  ```
  1. 服务端nginx虚拟主机配置：

    server {
      listen       80;
      server_name dev.cs.xiyoulinux.org;
      # root为项目代码中public文件夹所在的路径
      root /home/web/cs.xiyoulinux.org/public;
      
      location / {
        index  index.html index.php index.htm;
        try_files $uri $uri/ /index.php?$query_string;
      }

      location ~ \.php$ {
        fastcgi_pass    127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param   SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include         fastcgi_params;
      }
    }

  2. 浏览器端hosts文件设置
    
    //下面的IP为Web服务器所对应的IP
    127.0.0.1 dev.cs.xiyoulinux.org
  ```

1. **代码部署**

  ```
  // 拉取线上代码
  git clone https://github.com/xiyou-linuxer/cs-xiyoulinux.git
  
  // 移动代码
  mv cs-xiyoulinux /home/web/cs.xiyoulinux.org
  
  // 安装依赖
  composer install
  
  // 修改权限
  // 注：这里的nginx为启动nginx的用户名，如果没有配置的话，默认为nobody
  chown nginx.nginx storage -R
  chown nginx.nginx bootstrap/cache -R
  
  // 生成配置文件
  cp .env.sample .env
  
  // 生成App Key
  php artisan key:generate
  
  // 更新缓存
  php artisan config:cache
  ```
  
1. **协作开发（个人）**

  ```
  // 在github上fork主仓库
  // 主仓库地址为https://github.com/xiyou-linuxer/cs-xiyoulinux
  // fork之后，个人仓库地址为https://github.com/username/cs-xiyoulinux
  // 为避免引起混淆，对下文中所提到的名词作出如下约定:
  // 1. 主仓库    指xiyou-linuxer下的仓库
  // 2. 个人仓库  指开发人员fork之后的github仓库
  // 2. 本地仓库  指开发人员clone到本地的代码仓库

  // 拉取个人仓库代码到本地
  git clone https://github.com/username/cs-xiyoulinux.git  

  // 配置主仓库地址
  git remote add upstream https://github.com/xiyou-linuxer/cs-xiyoulinux.git

  // 配置好之后，可以通过一下命令查看当前的配置
  git remote -v

  // 编辑代码

  // 执行单元测试
  phpunit

  // 执行代码风格检测
  bash phpcs.sh
  // 目前忽略了一些目录，开发人员应自行对所做的文件进行检测
  phpcs filepath

  // 添加代码
  // git add filename添加单个文件
  // git add . 添加当前文件下所有文件
  // git add -A 添加所有更改（包括删除动作）
  git add xxx
  
  // 提交代码， 评论信息格式同分支名称
  // 新功能使用FEAT-前缀，bug修复使用FIX-前缀
  // 如果只是修改README等无需出发CI集成测试的话，可在commit信息中包含[ci skip]
  git commit
  
  // 拉取主仓库上master分支的最新代码
  git fetch upstream
  
  // 切换到本地仓库的master分支
  git checkout master
  
  // 将主仓库的master分支合并到本地仓库的master分支
  git merge upstream/master
  
  // 将本地仓库的修改提交到个人仓库上
  git push
  
  // 在github个人仓库上创建pull request，经管理员review之后，并入主仓库
  ```
1. **协作开发（团队）**

  ```
  // 基于master分支创建新的分支
  // 新功能使用feat-前缀命名, 例如：feat-profile
  // bug修复使用fix-前缀命名，例如：fix-csrf
  git checkout -b xxx
  
  // 编辑代码
  
  // 执行单元测试
  phpunit
  
  // 执行代码风格检测
  bash phpcs.sh
  // 目前忽略了一些目录，开发人员应自行对所做的文件进行检测
  phpcs filepath
  
  // 添加代码
  // git add filename添加单个文件
  // git add . 添加当前文件下所有文件
  // git add -A 添加所有更改（包括删除动作）
  git add xxx
  
  // 提交代码， 评论信息格式同分支名称
  // 新功能使用FEAT-前缀，bug修复使用FIX-前缀
  git commit
  
  // 切换到master分支
  git checkout master
  
  // 拉取线上最新代码
  git pull origin master
  
  // 切换到正在开发的分支
  git checkout xxx
  
  // 使用rebase命令合并master分支，同时可根据需要修改提交历史
  git rebase -i master
  
  // 将开发分支提交到远程分支上
  // 如需覆盖线上分支代码，可加参数-f（注意不要轻易覆盖别人创建的分支）
  git push origin xxx
  
  // 在github上创建pull request，经管理员review之后，并入master分支
  ```
