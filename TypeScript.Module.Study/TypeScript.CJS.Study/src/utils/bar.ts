/*
 * @Author       : Shandong Xiedali
 * @Mail         : 9727005@qq.com
 * @Date         : 2025/2/1 20:22:56
 * @FilePath     : myTools.ts
 * @Description  :
 * Copyright (c) 2025 by Hiland & RainyTop, All Rights Reserved.
 */

/**
 * 自定义工具类
 */
class Bar {
    private readonly name: string;
    constructor(name: string) {
        this.name = name;
    }

    sayHello() {
        console.log(`Hello, ${this.name}!`);
    }
}

module.exports = Bar;