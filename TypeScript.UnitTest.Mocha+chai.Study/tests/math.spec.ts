/*
 * @Author       : Shandong Xiedali
 * @Mail         : 9727005@qq.com
 * @Date         : 2025/2/2 22:32:49
 * @FilePath     : math.spec.ts
 * @Description  :
 * Copyright (c) 2025 by Hiland & RainyTop, All Rights Reserved.
 */
import { expect,assert } from 'chai';
import { describe, it } from "mocha";

import { Math } from '../src/math';

export default {
    describe: 'Math',
};
describe('math', () => {
    it('add', () => {
        expect(Math.add(1, 2)).equals(3);
        expect(Math.add(0, 0)).equals(0);
        expect(Math.add(-1, -2)).equals(-3);
    });

    it('minus', () => {
        expect(Math.subtract(1, 2)).equals(-1);
        expect(Math.subtract(0, 0)).equals(0);
        expect(Math.subtract(-1, -2)).equals(1);
    });

    it('multiply', () => {
        expect(Math.multiply(1, 2)).equals(2);
        expect(Math.multiply(0, 0)).equals(0);
        expect(Math.multiply(-1, -2)).equals(2);
    });

    it('divide', () => {
        expect(Math.divide(1, 2)).equals(0.5);
        expect(Math.divide(0, 0)).be.NaN;
        expect(Math.divide(-1, -2)).equals(0.5);
        // assert.isNaN(Math.divide(1, 0));
    });
});