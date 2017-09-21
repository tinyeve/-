<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Static_;

class TbCategory extends Model
{
	protected $table = 'tb_category' ;
	public $timestamps = false;
	protected $fillable = ['name','count','uid','state'];
	protected $guarded = ['id'];
	
	//定义类型的状态
	static $state = array('use'=>1, 'delete'=>0);
	
	//根据登录用户的uid，加载他的全部笔记类别
	public function findUserAll($uid=0)
	{
		if($uid!=0)
		{
			$st = self::$state['use'];
			$catArr = static::whereRaw("uid={$uid} and state={$st}")->get()->toArray();
			return $catArr;
		} 
		else
		{
			return null;			
		}
	}
		
	//查找$uid的第一个分类，不存在则创建一个，返回id
	public function firstOrNewId($uid)
	{
		$st = self::$state['use'];
		$modColl = static::whereRaw("uid={$uid} and state={$st}")->get();
		
		if($modColl->count()>0)
		{
			$id = $modColl->first()->getAttribute('id');
			return $id;
		}else{
			return $this->createNewCat($uid);
		}
	}
	
	//添加一个类别
	public function categoryAdd($param)
	{
		$param['name'] = isset($param['name']) ? $param['name']:'思维笔记';
		if(empty($param['uid'])){
			return ;
		}
		$this->create([
				'name' => $param['name'],
				'count' => 0,
				'uid' => $param['uid'],
				'state' => self::$state['use'],
		]);
	}
	
	//删除本用户 的一个分类
	public function deleteCat($uid,$cid)
	{
		$model = $this->find($cid);
		$model->state = self::$state['delete'];
		$model->save();
		return $this->firstOrNewId($uid);
	}
	
	//获取笔记的第一个分类
	public function firstId($uid)
	{
		$st = self::$state['use'];
		$modColl = static::whereRaw("uid={$uid} and state={$st}")->get();
		if ($modColl->count()>0)
		{
			$id = $modColl->first()->getAttribute('id');
			return $id;
		}else {
			return null;
		}
	}
	
	public function createNewCat($uid, $name = null)
	{
		$catName = $name ? $name : '思维笔记';
		$model = $this->create([
				'name' => $catName,
				'count' => 0,
				]);
		return $model['id'];
	}
	
	//分类中的笔记数量减少$num
	public function countReduce($cid,$num)
	{
		$model =  static::find($cid);
		$model->count = $model->count - $num;
		$model->save();		
	}
}