<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{

            DB::beginTransaction();

            $moduleNode = DB::table('permissions')->where(['name'=>'admin.category'])
                ->first();
            if($moduleNode){
                dd('该节点已存在，不需要重复执行');
            }

            $moduleItem = [
                'name'=>'admin.category',
                'parent_id'=>0,
                'cn_name'=>'品类管理',
                'menu_name'=>'品类管理',
                'menu_show'=>1, ## 显示菜单开关,1开0关
                'guard_name'=>'admin',
                'is_menu'=>1, ## 是否作为菜单栏显示,1是 2否
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ];
            $moduleId = DB::table('permissions')->insertGetId($moduleItem);

            $listItem = [
                'name'=>'admin.category.list',
                'parent_id'=>$moduleId,
                'cn_name'=>'品类列表',
                'menu_name'=>'品类列表',
                'menu_show'=>1, ## 显示菜单开关,1开0关
                'guard_name'=>'admin',
                'is_menu'=>1, ## 是否作为菜单栏显示,1是 2否
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ];
            $listId = DB::table('permissions')->insertGetId($listItem);

            $addItem = [
                'name'=>'admin.category.add',
                'parent_id'=>$listId,
                'cn_name'=>'新增',
                'menu_name'=>'新增',
                'menu_show'=>1, ## 显示菜单开关,1开0关
                'guard_name'=>'admin',
                'is_menu'=>2, ## 是否作为菜单栏显示,1是 2否
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ];

            $editItem = [
                'name'=>'admin.category.edit',
                'parent_id'=>$listId,
                'cn_name'=>'编辑',
                'menu_name'=>'编辑',
                'menu_show'=>1, ## 显示菜单开关,1开0关
                'guard_name'=>'admin',
                'is_menu'=>2, ## 是否作为菜单栏显示,1是 2否
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ];

            $deleteItem = [
                'name'=>'admin.category.delete',
                'parent_id'=>$listId,
                'cn_name'=>'删除',
                'menu_name'=>'删除',
                'menu_show'=>1, ## 显示菜单开关,1开0关
                'guard_name'=>'admin',
                'is_menu'=>2, ## 是否作为菜单栏显示,1是 2否
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ];

            DB::table('permissions')->insert($addItem);
            DB::table('permissions')->insert($editItem);
            DB::table('permissions')->insert($deleteItem);

            DB::commit();
        }catch(\Exception $e){

            echo $e->getMessage();
            DB::rollBack();

        }
    }
}
