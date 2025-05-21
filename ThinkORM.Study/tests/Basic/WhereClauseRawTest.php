<?php
/**
 * @file   : WhereClauseTest.php
 * @time   : 17:22
 * @date   : 2025/5/17
 * @mail   : 9727005@qq.com
 * @creator: ShanDong Xiedali
 * @company: Less is more.Simple is best!
 */

namespace OrmStudy\Test\Basic;

use think\db\BaseQuery;
use think\facade\Db;
use PHPUnit\Framework\TestCase;
use WanRen\Environment\EnvHelper;

// +--------------------------------------------------------------------------
// |:TITLE:::::::| 使用说明
// ---------------------------------------------------------------------------
// |:DESCRIPTION:| 需要先配置数据库表，表结构为：`tests/.SQLs/m_abstract_logic_testing.sql`
// +--------------------------------------------------------------------------

// +--------------------------------------------------------------------------
// |::说明·| WhereOr过滤条件 在ThinkORM3.0.20和3.0.21版本中，差异较大，需要注意：
// |::说明·| 1. 在3.0.20版本中，whereOr内的条件跟whereOr外的条件之间是OR关系；
// |::说明·| 2. 在3.0.21版本中，whereOr内的条件跟whereOr外的条件之间是AND关系；

// |::说明·| 0. 无论哪个版本的whereOr，其内部各个子条件之间都是OR关系；
// +--------------------------------------------------------------------------

// +--------------------------------------------------------------------------
// |:TITLE:::::::| where/whereOr可以使用的参数总结
// ---------------------------------------------------------------------------
// |:DESCRIPTION:|
// |::说明·| 1. 多参数变量：`where('mobile','like','thinkphp%')`
// |::说明·| 2. 字符串：`where('mobile like "thinkphp%"')`
// |::说明·| 3. 闭包：`where(function($query){$query->where('mobile','like','thinkphp%');})`
// |::说明·| 4.1. 数组（一维，必须是"key=>value"的形式）：`where(['mobile' => 'thinkphp%', 'name' => '%thinkphp'])`
// |::说明·| 4.2. 数组（二维）：`where([['mobile','like','thinkphp%'], ['name','like','%thinkphp']])`
// |::说明·| 4.3. 数组（三维）：`where([[['mobile','like','thinkphp%'], ['name','like','%thinkphp']],[['id','=',1], ['grade','=',3]]])`

//4.3使用的三维数组：
[
    [
        ['mobile', 'like', 'thinkphp%'],
        ['name', 'like', '%thinkphp']
    ],
    [
        ['id', '=', 1],
        ['grade', '=', 3]
    ]
];
// +--------------------------------------------------------------------------


class WhereClauseRawTest extends TestCase
{
    private static string $targetTable = "abstract_logic_testing";

    private function getTargetTableWithPrefix(): string
    {
        return "m_" . self::$targetTable;
    }

    private function getQueryObject(): BaseQuery
    {
        /** @noinspection all */
        return Db::name(self::$targetTable);
    }

    /**
     * @param string $whereString4Version3020AndBelow
     * @param string $whereString4Version3021AndAbove
     * @return void
     */
    private function assertDetails(string $whereString4Version3020AndBelow, string $whereString4Version3021AndAbove = ""): void
    {
        $actual = $this->getQueryObject()->getLastSql();
        print_r(PHP_EOL . "──实际SQL语句：───────────────────────────────────" . PHP_EOL);
        print_r($actual);

        $thinkOrmVersion = EnvHelper::getVendorLibraryVersion("topthink/think-orm");
        $expect          = "SELECT * FROM `m_abstract_logic_testing` WHERE";
        if (version_compare($thinkOrmVersion, 'V3.0.20', '<=')) {
            $expect .= $whereString4Version3020AndBelow;
        } else {
            $expect .= $whereString4Version3021AndAbove;
        }
        self::assertEquals($expect, $actual);
    }

    protected function setUp(): void
    {
        DbAssert::initDb();
    }

    private array $map1 = ['mobile', 'like', 'thinkphp%'];
    private array $map2 = ['name', 'like', '%thinkphp'];
    private array $map3 = ['grade', '=', 3];
    private array $map4 = ["id", "=", 1];

    public function test_and_params(): void
    {
        $this->getQueryObject()->where('mobile', 'like', 'thinkphp%')->select();

        $expect4Version3020AndBelow = "  `mobile` LIKE 'thinkphp%'";
        $expect4Version3021AndAbove = "  `mobile` LIKE 'thinkphp%'";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_or_params(): void
    {
        $this->getQueryObject()->where('id', '=', 1)->whereOr('mobile', 'like', 'thinkphp%')->select();

        $expect4Version3020AndBelow = "  `id` = 1 OR `mobile` LIKE 'thinkphp%'";
        $expect4Version3021AndAbove = "  `id` = 1 OR `mobile` LIKE 'thinkphp%'";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_and_level1(): void
    {
        $where = ['mobile' => 'thinkphp%', 'name' => '%thinkphp'];
        $this->getQueryObject()->where($where)->select();

        $expect4Version3020AndBelow = "  `mobile` = 'thinkphp%'  AND `name` = '%thinkphp'";
        $expect4Version3021AndAbove = "  `mobile` = 'thinkphp%'  AND `name` = '%thinkphp'";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_or_level1(): void
    {
        $whereOr = ['mobile' => 'thinkphp%', 'name' => '%thinkphp'];
        $this->getQueryObject()->whereOr($whereOr)->select();

        $expect4Version3020AndBelow = "  `mobile` = 'thinkphp%'  OR `name` = '%thinkphp'";
        $expect4Version3021AndAbove = "  `mobile` = 'thinkphp%'  OR `name` = '%thinkphp'";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_and_level2(): void
    {
        $where[] = $this->map1;
        $where[] = $this->map2;
        $this->getQueryObject()->where($where)->select();

        $expect4Version3020AndBelow = "  `mobile` LIKE 'thinkphp%'  AND `name` LIKE '%thinkphp'";
        $expect4Version3021AndAbove = "  (  `mobile` LIKE 'thinkphp%'  AND `name` LIKE '%thinkphp' )";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_or_level2_element(): void
    {
        $where[]   = $this->map1;
        $whereOr[] = $this->map2;
        $this->getQueryObject()->where($where)->whereOr($whereOr)->select();

        $expect4Version3020AndBelow = "  `mobile` LIKE 'thinkphp%' OR `name` LIKE '%thinkphp'";
        $expect4Version3021AndAbove = "  (  `mobile` LIKE 'thinkphp%' )  AND (  `name` LIKE '%thinkphp' )";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_or_level2_elements(): void
    {
        $where[]   = ['id', '=', 1];
        $whereOr[] = ['name', 'like', '%thinkphp'];
        $whereOr[] = ['mobile', 'like', 'thinkphp%'];

        $this->getQueryObject()->where($where)->whereOr($whereOr)->select();
        $expect4Version3020AndBelow = "  `id` = 1 OR `name` LIKE '%thinkphp'  OR `mobile` LIKE 'thinkphp%'";
        $expect4Version3021AndAbove = "  (  `id` = 1 )  AND (  `name` LIKE '%thinkphp'  OR `mobile` LIKE 'thinkphp%' )";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    // +--------------------------------------------------------------------------
    // |::说明·| 如果给where/whereOr传递的是一个3维数组，会在第二个维度上自动加括号，以保证逻辑的顺序。
    // 无论是where还是whereOr，在第二个为维度上的各个子条件都是AND关系。
    // +--------------------------------------------------------------------------

    public function test_and_level3(): void
    {
        $where1 = [$this->map1, $this->map2]; //会自动加括号
        $where2 = [$this->map3, $this->map4]; //会自动加括号
        $where  = [$where1, $where2];

        $this->getQueryObject()->where($where)->select();
        $expect4Version3020AndBelow = "  ( `mobile` LIKE 'thinkphp%' AND `name` LIKE '%thinkphp' )  AND ( `grade` = 3 AND `id` = 1 )";
        $expect4Version3021AndAbove = "  (  ( `mobile` LIKE 'thinkphp%' AND `name` LIKE '%thinkphp' )  AND ( `grade` = 3 AND `id` = 1 ) )";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_or_level3(): void
    {
        $where   = [[$this->map1, $this->map2]]; //会自动加括号
        $whereOr = [[$this->map3, $this->map4]]; //会自动加括号

        $this->getQueryObject()->where($where)->whereOr($whereOr)->select();
        $expect4Version3020AndBelow = "  ( `mobile` LIKE 'thinkphp%' AND `name` LIKE '%thinkphp' ) OR ( `grade` = 3 AND `id` = 1 )";
        $expect4Version3021AndAbove = "  (  ( `mobile` LIKE 'thinkphp%' AND `name` LIKE '%thinkphp' ) )  AND (  ( `grade` = 3 AND `id` = 1 ) )";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }


    public function test_string(): void
    {
        $where = "id=1 and grade=3";
        $this->getQueryObject()->where($where)->select();
        $expect4Version3020AndBelow = "  ( id=1 and grade=3 )";
        $expect4Version3021AndAbove = "  ( id=1 and grade=3 )";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }

    public function test_closure(): void
    {
        $where = function ($query) {
            $query
                ->where("mobile", "like", "thinkphp%")
                ->where("name", "like", "%thinkphp");
        };
        $this->getQueryObject()->where($where)->select();
        $expect4Version3020AndBelow = "  (  `mobile` LIKE 'thinkphp%'  AND `name` LIKE '%thinkphp' )";
        $expect4Version3021AndAbove = "  (  `mobile` LIKE 'thinkphp%'  AND `name` LIKE '%thinkphp' )";

        $this->assertDetails($expect4Version3020AndBelow, $expect4Version3021AndAbove);
    }


    //public function testConditionOrMulti_for_portable(): void
    //{
    //    $where[]   = ['id', '=', 1];
    //    $whereOr[] = ['name', 'like', '%thinkphp'];
    //    $whereOr[] = ['mobile', 'like', 'thinkphp%'];
    //
    //    Db::name("abstract_logic_testing")->where($where)->whereOr($whereOr)->select();
    //
    //    $actual = Db::name("abstract_logic_testing")->getLastSql();
    //
    //    $thinkOrmVersion = EnvHelper::getVendorLibraryVersion("topthink/think-orm");
    //    if (version_compare($thinkOrmVersion, 'V3.0.20', '<=')) {
    //        $expect = "SELECT * FROM `m_abstract_logic_testing` WHERE  `id` = 1 OR `name` LIKE '%thinkphp'  OR `mobile` LIKE 'thinkphp%'";
    //    } else {
    //        $expect = "";
    //    }
    //    self::assertEquals($expect, $actual);
    //}


}