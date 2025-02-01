/*
 * @Author       : Shandong Xiedali
 * @Mail         : 9727005@qq.com
 * @Date         : 2025/2/1 20:10:09
 * @FilePath     : index.ts
 * @Description  :
 * Copyright (c) 2025 by Hiland & RainyTop, All Rights Reserved.
 */

//commonjs模块系统，也可以使用ES6模块系统的import语法
import axios from 'axios';

const url = 'https://www.baidu.com';

axios.get(url).then(res => {
    console.log(res.data);
}).catch(err => {
    console.log(err);
});
