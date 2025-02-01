/*
 * @Author       : Shandong Xiedali
 * @Mail         : 9727005@qq.com
 * @Date         : 2025/2/1 20:40:52
 * @FilePath     : 2.local-module-using.ts
 * @Description  :
 * Copyright (c) 2025 by Hiland & RainyTop, All Rights Reserved.
 */
import { Foo } from "./utils/foo";

const myFoo = new Foo("lisi");
myFoo.sayHello();
