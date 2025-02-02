/*
 * @Author       : Shandong Xiedali
 * @Mail         : 9727005@qq.com
 * @Date         : 2025-01-12 15:17:50
 * @LastEditors  : Shandong Xiedali
 * @LastEditTime : 2025-01-12 16:53:45
 * @FilePath     : math.spec.ts
 * @Description  : 
 * Copyright (c) 2025 by Hiland & RainyTop, All Rights Reserved. 
 */
import { expect, test, describe, it } from 'vitest';
import { Math } from '../../src/data/math';

//简单测试
test('adds 1 + 2 to equal 3', () => {
    expect(Math.add(1, 2)).toBe(3)
})

//套件化测试
describe('Math', () => {
    it('should add two numbers', () => {
        const result = Math.add(2, 3);
        expect(result).toBe(5);
    });

    it('should subtract two numbers', () => {
        const result = Math.subtract(5, 3);
        expect(result).toBe(2);
    });

    it('should multiply two numbers', () => {
        const result = Math.multiply(2, 3);
        expect(result).toBe(6);
    });

    it('should divide two numbers', () => {
        const result = Math.divide(6, 3);
        expect(result).toBe(2);
    })
})