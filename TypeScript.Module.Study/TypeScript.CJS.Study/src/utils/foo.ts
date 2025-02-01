/*
 * @Author       : Shandong Xiedali
 * @Mail         : 9727005@qq.com
 * @Date         : 2025-02-01 22:15:11
 * @LastEditors  : Shandong Xiedali
 * @LastEditTime : 2025-02-01 22:15:13
 * @FilePath     : bar copy.ts
 * @Description  : (description here)
 * @Copyright (c) 2025 by WRJT Co., Ltd., All Rights Reserved.
 */


/**
 * 自定义工具类
 */
export class Foo {
    private readonly name: string;
    constructor(name: string) {
        this.name = name;
    }

    sayHello() {
        console.log(`Hello, ${this.name}!`);
    }
}
