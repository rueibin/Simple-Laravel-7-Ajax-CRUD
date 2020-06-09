# Simple-Laravel-7-Ajax-CRUD



## 一、系統畫瀏覽

**列表頁**

![avatar](https://github.com/rueibin/Simple-Laravel-7-Ajax-CRUD/blob/master/public/images/list_page.JPG)

**新增頁**

![avatar](https://github.com/rueibin/Simple-Laravel-7-Ajax-CRUD/blob/master/public/images/create_page.JPG)

**編輯頁**

![avatar](https://github.com/rueibin/Simple-Laravel-7-Ajax-CRUD/blob/master/public/images/edit_page.JPG)



## 二、使用技術

前端：bootstrap-3.0.3，jquery-2.1.4，ajax，toastrJS。

後端：Laravel 7.x。



## 三、使用操作

1.下載程式碼 

- git clone https://github.com/rueibin/Simple-Laravel-7-Ajax-CRUD.git

2.進入專案目錄，之後composer安裝 install

- composer install

3.配置.evn 

- 將.env.example複製成.env

4.配置資料庫 

- DB_HOST=localhost
- DB_DATABASE=ssm_crud
- DB_USERNAME=root
- DB_PASSWORD=

5.匯入資料

- ssm_crud.sql

6.啟動伺服器

```
php artisan serve
```

7.打開瀏覽器輸入以下

```
http://127.0.0.1:8000/emp
```

