<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\Scheduling\Schedule;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	//建立用户表
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',32);
            $table->string('account',32)->unique();
            $table->string('password',60);
            $table->rememberToken();
            $table->unsignedInteger('addtime');
            $table->tinyInteger('state')->unsigned()->default(1);
            $table->timestamps();
        });
        
        //建立分类表
        Schema::create('tb_category',function (Blueprint $table)
        {
        	$table->increments('id');
        	$table->string('name',32);
        	$table->unsignedInteger('count')->default(0);
        	$table->integer('uid');		//用户id
        	$table->tinyInteger('state')->unsigned()->default(1);	//分类的状态，1为正常，0为删除
        });
        
        //建立笔记内容表
        Schema::create('tb_records',function(Blueprint $table){
        		$table->increments('id');
        		$table->string('title',64);
        		$table->text('content')->nullable();
        		$table->integer('cid');		//分类的id
        		$table->integer('uid');		//用户id
        		$table->unsignedInteger('addtime')->default(0);
        		$table->tinyInteger('state')->default(1)->unsigned();
 		       });
    }

    /**
     * Reverse the migrations.
     *回退迁移操作
     * @return void
     */
    public function down()
    {
    	Schema::drop('tb_records');
    	Schema::drop('tb_category');
        Schema::drop('users');
               
    }
}
