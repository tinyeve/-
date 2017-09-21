<?php  namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Validator;
use App\Models\User;
use App\Models\TbCategory;
use App\Models\TbRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WebController extends Controller
{
	//
	private $attributes = array();
	public function __construct(Guard $auth)
	{
		$this->middleware('auth');
		$this->auth = $auth;
		if($this->auth->user()){
			$this->authSave();
		}
	}
	
	private function authSave()
	{
		$this->attributes['username'] = $this->auth->user()->getAttribute('username');
		$this->attributes['uid'] = $this->auth->id();
	}
	//查属性信息函数getAttribute
	private function getAttribute($key)
	{
		return $this->attributes[$key];
	}
	
	private function addAttributes($param,$value)
	{
		$this->attributes[$param] = $value;
	}
	// web访问根目录时的方法
	public function getIndex()
	{
 		$user = $this->auth->user();
		return view('/backyard/index/index')->with('attributes',$this->attributes);
	}
	//获取会员信息列表的方法
	public function getUserlist()
	{
		$model = new User();
		$data = $model->findAll()->toArray();
		$this->addAttributes("userList", $data);
		//将 attributes['userList']的数组传递给/backyard/user/index视图
		return view("/backyard/user/index")->with("attributes",$this->attributes);  
	}
	
	public function getCategorylist()
	{
		$model = new TbCategory();
		$catList = $model->findUserAll($this->getAttribute('uid'));
		$this->addAttributes('catList', $catList);
		return view("/backyard/category/index")->with('attributes',$this->attributes);
	}
	//处理以get方式请求的笔记类别增加，即查看增加页面
	public function getCategoryadd()
	{
		return view("/backyard/category/add")->with("attributes",$this->attributes);
	}
	//以post方式请求的增加笔记类别
	public function postCategoryadd()
	{
		$model = new TbCategory();
		$param = $_POST;
		$param['uid'] = $this->getAttribute('uid');
		$param['count'] = 0;
		$param['state'] = TbCategory::$state['use'];
		$model->categoryAdd($param);
		return redirect("/web/categorylist");		//重定向到控制器Webcontroller的Categorylist方法，以默认get方式
	}
	//删除一个分类，要注意删除分类是需要处理分类中现有的笔记
	public function getDeletecat($cid)
	{
		$model = new TbCategory();
		$nextId = $model->deleteCat($this->getAttribute('uid'), $cid);
		$recordModel = new TbRecords();
		$num = $recordModel->changeId($this->getAttribute('uid'), $cid, $nextId);
		$nextCat = $model->find($nextId);
		$nextCat->count += $num;
		$nextCat->save();
		return redirect("/Web/Categorylist");
	}
	//加载某一分类下的笔记列表页
	public function getNoteslist($cid=0)
	{
		$model = new TbRecords();
		$value = $model->findUserAll($this->attributes['uid'], $cid);
		$this->addAttributes('recordsList', $value);
		return view("/backyard/notes/index")->with('attributes',$this->attributes);
	}
	public function getNotesadd()
	{
		$model = new TbCategory();
		$data = $model->findUserAll($this->getAttribute('uid'));
		$this->addAttributes('cglist', $data);
		return view('/backyard/notes/add')->with('attributes',$this->attributes);
	}
	//验证插入笔记内容的方法如下
	private function validator(array $data)
	{
		return Validator::make( $data,[
				'title' => 'required|max:255',
				'content' => 'required',
				// 'cid' => 'required',
		] );		
	}
	public function postNotesinsert()
	{
		//先对请求的数据进行验证
		$validator = $this->validator(Request::all());
		if($validator->fails())
		{
			$this->throwValidationException(Request::instance(), $validator);
		}
		//准备数据
		$model = new TbCategory();
		$param = $_POST;
		$param['uid'] = $this->getAttribute('uid');
		$param['cid'] = (!empty($param['cid'])) ? $param['cid']:$model->firstOrNewId($this->getAttribute('uid'));
		$param['addtime'] = time();
		// $param['state'] = 1;
		$rmodel = new TbRecords();
		$param['state'] = 1 ;
		//存储笔记		
		$result = $rmodel->insert($param);
		if($result){
			return redirect("/web/noteslist");
		} else {
			return redirect("/web/notesadd");
		}
	}
	
	public function getNoteedit($id)
	{
		$model = new TbCategory();
		$catList = $model->findUserAll($this->getAttribute('uid'));
		$this->addAttributes('cglist', $catList);
		$model = TbRecords::find($id);
		$data = $model->toArray();
		$data['attributes'] = $this->attributes;
		return view('/backyard/notes/edit', $data);
	}
	public function postNotechange($id)
	{
		$model = TbRecords::find($id);
		$model->fill($_POST);
		$model->save();
		return redirect("/web/noteslist");
	}
	public function getNoteshow($id)
	{
		$model = TbRecords::find($id);
		$data = $model->getAttributes();
		$data['attributes'] = $this->attributes;		
		return view("/backyard/notes/show",$data);
	}
	public function getDeletenote($id)
	{
		$model = TbRecords::find($id);
		$model->state = TbRecords::$state['delete'];
		$cid = $model->cid;
		$model->save();
		$catModel = new TbCategory();
		$catModel->countReduce($cid, 1);
		return view("/web/noteslist");
	}
	

}