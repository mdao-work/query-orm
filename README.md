# composer require mdao/query_orm


# 查询表达式
表达式不分大小写，支持的查询表达式有下面几种，分别表示的含义是：

| 表达式                         | 描述             |
| ------------------------------ | ---------------- |
| filter[field[eq]]=1            | 等于             |
| filter[field[NEQ]]=1           | 不等于           |
| filter[field[GT]]=1            | 大于             |
| filter[field[EGT]]=1           | 大于等于         |
| filter[field[LT]]=1            | 小于             |
| filter[field[ELT]]=1           | 小于等于         |
| filter[field[LIKE]]=1          | 模糊查询         |
| filter[field[[NOT] IN]]=1      | （不在）区间查询 |
| filter[field[[NOT] BETWEEN]]=1 | （不在）IN 查询  |


## 逻辑运算-筛选
### 单字段查询
1.筛选出，ID 在12,15,32中的这三条数据的
 >`url?filter[created_at[in]]=12,15,32`
```php
$where=['id','in',['12,15,32']];
```

2. 筛选出，ID 等于12的数据
 >`url?filter[created_at]=12`
```php
$where=['id','=',12];
```

3. 筛选出，ID >=12的数据
 >`url?filter[created_at[>=]]=12`
```php
$where=['id','>=',12];
```

3. 筛选出，ID <=12的数据
 >`url?filter[created_at[<=]]=12`
```php
$where=['id','<=',12];
```
### 联合查询

## 字段过滤

