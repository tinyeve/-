<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TbRecords extends Model
{
	protected $table = 'tb_records';
	public $timestamps = false;
	protected $fillable = ['title','content','cid','uid','addtime','state'];
	protected $guarded = ['id'];
	
	static $state = array('use'=>1, 'delete'=>0);
	
	//执行增加操作，操作成功返回TRUE，失败返回FALSE
	public function insert($param)
	{
		if(isset($param['uid']) && $param['uid']>0)
		{
			$catmodel = new TbCategory();
			$param['cid'] = isset($param['cid']) ? $param['cid'] : $catmodel->firstOrNewId($param['cid']);
			$this->fill($param);	//使用数组填充模型
			$suc = $this->save();	//保存填充好的模型到database，$suc为返回值 true\false
			if($suc){
				$cat = TbCategory::find($param['cid']);
				$cat->count +=1;
				return $cat->save();
			}
		}
		return false;		
	}
	
	//查找用户的记录
	public function findUserAll($uid, $cid=0)
	{
		$st = self::$state['use'];
		if($cid>0)
		{
			$recordsList = static::whereRaw("uid = {$uid} and cid = {$cid} and state = {$st}")->get()->toArray();
		}else{
			$recordsList = static::whereRaw("uid={$uid} and state={$st}")->get()->toArray();
		}
		return $recordsList;
	}
	
	//修改用户$uid的笔记类型从$cid变成$nextId
	public function changeId($uid,$cid,$nextId)
	{
		$st = self::$state['use'];
		return static::whereRaw("uid={$uid} and cid={$cid} and state={$st}")->update("cid={$nextId}");
	}
}