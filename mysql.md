#MySQL命令#
[TOC]
##连接数据库##
###连接数据库###
```mysql -u root -p```
并回车，然后提示输入密码
###连接远程数据库
```mysql -h yourIP -u root -p yourPWD```
##创建用户##
```GRANT ALl ON database.* TO 'username'@'localhost' IDENTIFIED BY 'password'```
授予用户username密码password只能以本地的形式登录数据库database
##数据库操作##
###创建数据库###
```CREATE DATABASE database;```
###显示数据库###
```SHOW DATABASES;```
###删除数据库###
```DROP DATABASE database;```
###选择数据库###
```USE database;```
##数据表操作##
###查看数据库中所有表###
```SHOW TABLES;```
###创建表###
```CREATE TABLE table(author VARCHAR(128),title VARCHAR(128));```
###要检查数据表是否创建成功,查看数据表结构###
```DESCRIBE table;```
###查看数据表结构###
```SHOW COLUMNS FROM table;```
###删除数据表###
```DROP TABLE table;```
###向表中插入数据###
```INSERT TABLE table[(<字段名1>[,..<字段名n>])]values(值1)[,(值n)];```
###重命名表###
```ALTER TABLE table RENAME newname;```
###删除某一列###
```ALTER TABLE table DROP id;```
###改变列中数据类型###
```ALTER TABLE table MIDIFY id SMALLINT;```
###添加新列###
```ALTER TABLE table ADD id SAMLLINT UNSIGNED;```
###重命名列###
```ALTER TABLE table CHANGE name newname VARCHAR(16);```
>ps：change关键字需要指明数据类型。
##数据类型##
###CHAR类型###
|数据类型|使用字节|实例
|---|---|
|CHAR(N)|精确的n(n<=255)|CHAR(5):"hello"使用5个字节
|||CHAR(57):"world"使用57个字节
|VARCHAR(n)|达到n(n<=65535)|VARCHAR(7):"MORNING"使用7个字节
|||VARCHAR(100):"NIGHT"使用5个字节
###BINARY数据类型###
BINARY(二进制)数据类型用来存储没有关联字符集的全字节字符串
|数据类型|使用的字节|
|---|---|
|BINARY(n)或BYTE(n)|精确的n|
|VARBINARY(n)|达到n|
###TEXT和VARCHAR数据类型
文本和可变长字符串数据类型差距很小:

 - TEXT字段没有默认值
 - MySQL只能检索TEXT列的前n个字符（当创建索引时制定n)
|数据类型|使用的字节|属性|
|---|---|---|
|TINYTEXT|达到n(<=255)|用字符集处理一个字符串
|TEXT(n)|达到n(<=65535)|用字符集处理一个字符串
|MEDIUMTEXT|到达n(<=1.67e+7)|用字符集处理一个字符串
|LONGTEXT|达到n(<=4.29e+9)|用字符集处理一个字符串
###数值型数据类型###
|数据类型|使用的字节|最小值|最大值|
|---|
|TINYINT|1|-128 0|127 255|
|SMALLINT|2|-32768 0|32767 65535|
|MEDIUMINT|3|
|INT/INTEGER|4|
|BIGINT|8|
|FLOAT|4|
|DOUBLE/REAL|8|
###AUTO_INCREMENT自增###
##索引##
###创建索引###
```ALTER TABLE table ADD INDEX(id(20));```
###主键###
```ALTER TABLE table ADD id CHAR(10) PRIMARY KEY;```
##数据库查询##
###SELECT###
```SELECT something FROM table;```
> something可以是*，也可以是一个列或多个列。
###SELECT COUNT###
统计行数
```SELECT COUNT(*) FROM table;```
###SELECT DISTINCT###
该限定词能够清除包含相同数据的多重输入
###UODATE...SET###
```UPDATE table SET id="" WHERE id="";```
##规范化##
###第一范式###
- 不能有包含相同类型的数据的重复列出现
- 所有的列都是单值的
- 要有一个主键来标识每一行
###第二范式###
- 处理多行间的冗余
###第三范式###
- 要求数据不直接依赖主键，但根据相关性，也要将依赖于表中其他值得数据迁移到其他单独的表中
##备份和恢复##
###使用mysqldump###
> 使用的时候必须确保没有人向表内写入数据，可以先锁定要备份的表
锁定表操作：
```LOCK TABLES table READ;```
解锁：
```UNLOCK TABLES;```
> **需要在命令提示符进入MySQL的bin目录后执行**
备份一个表：
```mysqldump -u user -p database table    #在屏幕打印(没有分号！！)```
```mysqldump -u user -p database table > C:/classics.sql(没有分号！！)```
如果要备份所有表，修改参数`--all-databases`
```mysqldump -u user -p --all-databases > all_databases.sql```
##从备份中恢复数据库##
> 恢复一个完整的数据库集
```mysql -u user -p < all_databases.sql```
> 恢复一个数据库
```mysqldump -u user -p -D database < database.sql```


 
