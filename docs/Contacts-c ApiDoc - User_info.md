# Contacts-c ApiDoc - User_info


---

## **属性**
- **`【user_info 表】`**

| 属性名          | 中文     | 最小长度 | 最大长度 | 类型           | 特殊要求
| --------------- | ------   | -------- | -------- | ---------      | --------
| **UIid**        | 记录id   | -        | -        | int            | - 
| **Uuserid**     | 学号     | 9        | 9       | char(20)       | -                       
| **Uusername**   | 姓名     | -        | -        | char(20)       | -           
| **Uaddress**    | 地址     | -        | -        | char(20)      | -
| **Uuserphone**  | 手机号   | -        | -        | char(20)      | -
| **Uuserwechat** | 微信号   | -        | -        | char(20)      | -
| **Uuseremail**  | 电子邮件  | -        | -       | char(20)      |
| **Uuserqq**     | QQ号     | -        | -       | char(20)      | -
| **Uuserlang**   | 个性语言  | -        | -       | char(20)      | -

- **`【user_rela 表】`**

| 属性名          | 中文     | 最小长度 | 最大长度 | 类型           | 特殊要求
| --------------- | ------   | -------- | -------- | ---------      | --------
| **URid**        | 记录id   | -        | -        | int            | - 
| **Uuserid**     | 同学学号  | 9        | 9        | char(20)       | -
| **URrela**      | 用户学号  | 9        | 9        | char(20)       | -


---

## **接口 ·查询某个同学信息**
- **请求方法：GET**
- **接口网址：http://contacts-c.and-who.cn/User_info/get?Uuserid**

| **返回的学生信息** | 备注
| -------------------------- | ----
| **UIid**        | 记录id
| **Uuserid**     | 学号  
| **Uusername**   | 姓名  
| **Uaddress**    | 地址  
| **Uuserphone**  | 手机号 
| **Uuserwechat** | 微信号 
| **Uuseremail**  | 电子邮件
| **Uuserqq**     | QQ号 
| **Uuserlang**   | 个性语言


- **查询示例：http://contacts-c.and-who.cn/User_info/get?Uuserid=031502443**
- **成功返回**

```
{
	"type": 1,
	"message": "获取成功",
	"data": {
		"UTid": 1,
		"Uuserid": "031502443",
		"Uusername": "zsh",
		"Uaddress": "Fuzhou",
		"Uuserphone": "130557700000",
		"Uuserwechat": "shuhao",
		"Uuseremail": "shuhao@gmail.com",
		"Uuserqq": "10086",
		"Uuserlang": "Wow!"
	}
}
```


---

## **接口 · 删除文章**
- **请求方法：GET**
- **接口网址：http://contacts-c.and-who.cn/User_info/dlete?Uuserid**
- **表单要求**

| 属性名          | 必要性 | 最小长度 | 最大长度 | 特殊要求
| --------------- | ------ | -------- | -------- | --------
| **Uuserid**     | O      | -        | -        | -

- **成功返回**
```
{
	"type": 1,
	"message": "删除成功",
	"data": []
}
```


---

## **接口 · 增加同学**
- **请求方法：POST**
- **接口网址：http://contacts-c.and-who.cn/User_info/register**
- **表单要求**

| 属性名          | 必要性 | 最小长度 | 最大长度 | 特殊要求
| --------------- | ------ | -------- | -------- | --------
| **Uuserid**     | O      | 1        | 20       | -    
| **Uusername**   | O      | 1        | 20       | - 
| **Uaddress**    | X      | -        | 20       | -
| **Uuserphone**  | O      | 1        | 20       | -
| **Uuserwechat** | X      | 1        | 20       | -
| **Uuseremail**  | X      | 1        | 20       | -
| **Uuserqq**     | X      | 1        | 20       | -
| **Uuserlang**   | X      | 1        | 20       | -

- **示例**
```
{
	"Uuserid": "031502443",
	"Uusername": "zsh",
	"Uaddress": "Fuzhou",
	"Uuserphone": "130557700000",
	"Uuserwechat": "shuhao",
	"Uuseremail": "shuhao@gmail.com",
	"Uuserqq": "10086",
	"Uuserlang": "Wow!"
}
```

- **成功返回**
```
{
    "type": 1,
    "message": "增加成功",
    "data": []
}
```


---

## **接口 · 修改文章**
- **请求方法：POST**
- **接口网址：http://contacts-c.and-who.cn/User_info/update**
- **表单要求**

| 属性名          | 必要性 | 最小长度 | 最大长度 | 特殊要求
| --------------- | ------ | -------- | -------- | --------
| **Uuserid**     | O      | 1        | 20       | -    
| **Uusername**   | O      | 1        | 20       | - 
| **Uaddress**    | X      | -        | 20       | -
| **Uuserphone**  | O      | 1        | 20       | -
| **Uuserwechat** | X      | 1        | 20       | -
| **Uuseremail**  | X      | 1        | 20       | -
| **Uuserqq**     | X      | 1        | 20       | -
| **Uuserlang**   | X      | 1        | 20       | -


- **示例**
```
{
	"Uuserid": "031502443",
	"Uusername": "zsh",
	"Uaddress": "Fuzhou",
	"Uuserphone": "130557700000",
	"Uuserwechat": "shuhao",
	"Uuseremail": "shuhao@gmail.com",
	"Uuserqq": "10086",
	"Uuserlang": "Wow!"
}
```

- **成功返回**
```
{
    "type": 1,
    "message": "修改成功",
    "data": []
}
```


---

## **接口 · 获取某用户的同学列表**
- **请求方法：GET**
- **按学号排序**
- **接口网址：http://contacts-c.and-who.cn/Blog/get_list?Uuserid**

| **`GET` 字段可选项** | 备注
| --------------- | --------
| **page_size**   | 设置分页大小，和 **page** 成对存在
| **page**        | 设置查询页，和 **page_size** 成对存在
| **orderby**     | 设置排序关键字，可选：**`Uuserid` `Uusername`**

| 返回的json数组包括  | 备注
| --------------- | --------
| **page_size**   | 分页大小
| **page**        | 当前页
| **page_max**    | 最大页数
| **total**       | 总条目

| 返回的data(1个学生的信息) | 备注
| ---------------- | --------
| **UIid**        | 记录id
| **Uuserid**     | 学号  
| **Uusername**   | 姓名  
| **Uaddress**    | 地址  
| **Uuserphone**  | 手机号 
| **Uuserwechat** | 微信号 
| **Uuseremail**  | 电子邮件
| **Uuserqq**     | QQ号 
| **Uuserlang**   | 个性语言

- **查询示例：http://contacts-c.and-who.cn/Blog/get_list?Uuserid=031502443**
- **查询示例：http://contacts-c.and-who.cn/Blog/get_list?Uuserid=031502443&&page_size=1&&page=2**
```
{
	"type": 1,
	"message": "获取成功",
	"data": {
		"total": 1,
		"page_size": "1",
		"page": "3",
		"page_max": 1,
		"editable": true,
		"data": [
			[
				{
					"UIid": "4",
					"Uuserid": "031502437",
					"Uusername": "yhh",
					"Uadress": "Fuzhou",
					"Uuserphone": "130557700001",
					"Uuserwechat": "haihui",
					"Uuseremail": "haihui@gmail.com",
					"Uuserqq": "10087",
					"Uuserlang": "Yeah!"
				}
			]
		]
	}
}
```


