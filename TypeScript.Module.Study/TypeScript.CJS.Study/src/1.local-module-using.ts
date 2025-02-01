/*
 * @Author       : Shandong Xiedali
 * @Mail         : 9727005@qq.com
 * @Date         : 2025/2/1 20:40:52
 * @FilePath     : 1.local-module-using.ts
 * @Description  :
 * Copyright (c) 2025 by Hiland & RainyTop, All Rights Reserved.
 */

//TODO:xiedali@2025/02/01 怎么才能不让IDE出现对require的警告？

const MyBar = require("./utils/bar");

const myBar = new MyBar("zhangsan");
myBar.sayHello();

