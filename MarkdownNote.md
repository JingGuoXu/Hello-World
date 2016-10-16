#Markdown学习笔记
##1.字体
**粗体**

*斜体*
##2.标题
---
这是一个二级标题
---
###这是一个三级标题
##3.外部链接
[这是Google的网址](http://www.google.cn)
##4.无序列表
使用*，+，-表示无序列表

- 无序列表 1
- 无序列表 2
- 无序列表 3

##5.有序列表
1. 有序列表 1
2. 有序列表 2
3. 有序列表 3

##6.文字引用
> 离离原上草，一岁一枯荣

##7.行内代码块
`<php>`
##8.代码块
    #include<stdio.h>
    void main(){
    printf("hello world!");
    }
##9.插入图像

![图像](https://www.zybuluo.com/static/img/my_head.jpg)

###Markdown高阶语法手册
##1.内容目录
[TOC]
###2.标签分类
标签 ： Markdown 学习笔记
##3.删除线
~~这是一段错误的文本~~
##4.注脚
注脚1[^footnote1]
注脚2[^footnote2]
##5.公式
$表示行内公式
$$表示正行公式

$E=mc^2$
$$\sum_i^n a_i=0$$
$$f(x_1,x_2,\ldots,x_n)=x_1^2+x_2^2+\ldots+x_n$$ 
##6.加强的代码块
非代码示例：
```
$sudo apt-get install vim
$sudo apt-get update
```
``` C
#include<stdio.h>
void main()
{
printf("hello world!");
}
```
``` PHP
<?php
//PHP code
    <?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller {
	public function insert(){              //插入
		$Form=D('Form');
		if($Form->create())
		{
			$result=$Form->add();
		
			if($result){
				$this->success("do it");
				//echo I('post.title');
			}
			else{
				$this->error("error");
				//$this->error($Form->getError());
			}
		//$this->display();
		}
	else{
			//echo $Form->getError();
			$this->error($Form->getError());
		}
	}
  }
```
##7.流程图
```flow
st=>start: 开始
io=>inputoutput: 输入/输出
op=>operation: 操作
op2=>operation: 操作2
con=>condition: a>0?
e=>end: 结束

st->io->op->con
con(yes)->e
con(no)->op2->e
```
##8.序列图
```seq
Alice->Bob:good morning,Bob!
Note right of Bob: 老实人抛你家祖坟啦？
Bob->>Alice: 这个盘我不接
```
##9.甘特图
甘特图内在思想简单。基本是一条线条图，横轴表示时间，纵轴表示活动（项目），线条表示在整个期间上计划和实际的活动完成情况。它直观地表明任务计划在什么时候进行，及实际进展与计划要求的对比。

```gantt
title 项目开发流程
section 项目确定
        需求分析 :a1, 2016-06-22, 6d
        可行性报告 :after a1, 5d
        概念验证 : 5d
section 项目实施
        概要设计 :2016-07-05, 5d
        详细设计 :2016-07-08, 10d
        编码 :2016-07-15, 10d
        测试 :2016-07-22, 5d
section 发布验收
        发布: 2d
        验收: 3d
```
##10.表格支持
|项目| 价格|数量|
|-----|----:|:----:|
|计算机|\$1600|5|
|手机|\$120|12|
|管线|$1|123|
##11.HTML标签
<table>
    <tr>
        <td>hello</td>
        <td>world</td>
    </tr>
    <tr>
        <td>i am learning Markdown</td>
        <td>markdown</td>
</table>
 
[^footnote1]: 注脚1的**文本**

[^footnote2]: 注脚2的**文本**

