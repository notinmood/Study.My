// /// <reference types="vitest">
// import { defineConfig } from "vite";
// import * as path from "path";
//
// // https://vitejs.dev/config/
// export default defineConfig({
//     // 单元测试
//     test: {
//         globals: true,  //全局注册
//         environment: 'jsdom', // 模拟浏览器环境
//     },
//     resolve: {
//         //设置别名
//         alias: {
//             "@": path.resolve(__dirname, "src"),
//         },
//     },
// });