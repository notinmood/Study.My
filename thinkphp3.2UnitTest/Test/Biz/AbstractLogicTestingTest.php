<?php
/**
 * @file   : AbstractLogicTestingTest.php
 * @time   : 11:04
 * @date   : 2025/6/13
 * @mail   : 9727005@qq.com
 * @creator: ShanDong Xiedali
 * @company: Less is more.Simple is best!
 */

namespace Test\Biz;

use Test\Biz\AbstractLogicTestingModel;
use PHPUnit\Framework\TestCase;

class AbstractLogicTestingTest extends TestCase
{
//    protected function setUp(): void
//    {
//
//        //导入要测试的控制器
//        include_once 'E:\www\novel\Application\Home\Controller\IndexController.php';
//    }


//    public static function setupBeforeClass(): void
//    {
//        // 下面四行代码模拟出一个应用实例, 每一行都很关键, 需正确设置参数
//        self::$app = new \Think\PhpunitHelper();
//        self::$app->setMVC('domain.com','Home','Index');
//        self::$app->setTestConfig(['DB_NAME'=>'test', 'DB_HOST'=>'127.0.0.1',]); // 一定要设置一个测试用的数据库,避免测试过程破坏生产数据
//        self::$app->start();
//    }

    function __construct()
    {
        parent::__construct();

        //定义目录路径，最好为绝对路径
        //define('TP_BASEPATH', 'D:/HOME/MySpace/Study.TP32/');
        //导入base库
        include_once 'D:\HOME\MySpace\Study.TP32\tests\TPUnit\base.php';
        ////导入要测试的控制器
        //include_once 'D:\HOME\MySpace\Study.TP32\Application\Home\Controller\IndexController.class.php';


    }

    public function testGetSome(): void
    {
        $expect = 3;

        $model  = new AbstractLogicTestingModel();
        $list   = $model->select();
        $actual = count($list);
        self::assertEquals($expect, $actual);
    }
}