<?php

namespace App\Http\Controllers;

use Redis;
use App\Model\User;
use App\Model\Question;
use Illuminate\Http\Request;
use App\Events\QuestionsEvent;
use App\Events\QuestionSendEvent;
use App\Events\QuestionsDelEvent;
use App\Http\Requests\QuestionRequest;
use App\Repositories\QuestionRepository;



class QuestionsController extends BaseController
{
    protected $questionRepository;


    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->middleware('auth')->except(['index','show','follow','hot']);
    }

    // 知乎首页
    public function index()
    {   

        // 通过repository获得数据，使控制器与模型层分离
        $questions = $this->questionRepository->all();

        // 锁定推荐类型
        $recommend = true;
        $type = 'recommend';

        return view('questions.index', compact('questions','recommend','type'));

    }


    // 首页关注
    public function follow()
    {
        if(authCheck()){
            $res = authUser()->follower;
            if(!$res->isEmpty()){
                    $questions = $res->map(function($value){
                        $user_question = $value->self_question()->first();
                        if($user_question){
                                $value->question_title = $user_question->title;
                                $value->question_body = $user_question->body;

                                preg_match( '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',$value->question_body,$res);
                                $res = isset($res[1])&&!empty($res[1]) ? $res[1] : '';
                                $value->cover = $res;

                        }
                        return $value;
                    });
                    $is_exist_following_user = true;//是否存在关注的用户
            }else{
                    $is_exist_following_user = false;//随机推荐给当前用户
                    $res = User::where('questions_count','>','0')->Where('id','!=',authId())->orderBy(\DB::raw('RAND()'))->limit(10)->get();
                        $rand_user = $res->map(function($value){
                            $user_question = $value->self_question()->first();
                            if($user_question){
                                    $value->question_title = $user_question->title;
                                    $value->question_body = $user_question->body;

                                    preg_match( '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',$value->question_body,$res);
                                    $res = isset($res[1])&&!empty($res[1]) ? $res[1] : '';
                                    $value->cover = $res;

                            }
                            return $value;
                        });


            }


            $rand_user = isset($rand_user) ? $rand_user : array();
            $questions = isset($questions) ? $questions : array();

        }else{

            $questions = '';
        }




        $follow = true; 
        $type = 'follow';               
        return view('questions.index', compact('questions','follow','type','is_exist_following_user','rand_user'));
    }

    // 首页热榜
    public function hot()
    {
        $questions = $this->questionRepository->getHotData();

        // 锁定热榜类型
        $hot = true;
        $type = 'hot';
        return view('questions.index', compact('questions','hot','type'));
    }







    // 问题表单创建页
    public function create()
    {

    	return view('questions.make');

    }



    

    // 发表问题(提交)
    public function store(QuestionRequest $request)
    {   


        $topic_id = $this->questionRepository->normalTopic($request->get('topics'),'store');
        $question = $this->questionRepository->store($request);


        broadcast(new QuestionSendEvent($question,$topic_id))->toOthers();//用户发表文章后，广播全站,但是自己不能接收
        return redirect()->route('questions.show',['id' => $question->id]);

    }


    public function edit($id)
    {
        $question = $this->questionRepository->getById($id);

        if(!authUser()->owns($question)){
            return back();
        }

        return view('questions.edit',compact('question'));
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function update(QuestionRequest $request, $id)
    {

        $data = $this->questionRepository->update($request,$id);
        $topic_id = $this->questionRepository->normalTopic($request->get('topics'),'update',$data['question']);
        $data['question']->topics()->sync($topic_id); //对问题的所属主题进行更新

        $data['res'] == 1 ? flash('编辑成功')->success() : flash('编辑失败')->error();
        return redirect()->route('questions.show',['id' => $id]);
    }



    // 内容详情页
    public function show($id)
    {

        $data = $this->questionRepository->getById($id);
        $data->increment('look');

        $like_user = Redis::smembers('question:'.$id);
        $count = Redis::get('like_count'.$id);
        $count = $count ? $count : 0 ;
        $likes = array();
        if(!empty($like_user)){
            foreach ($like_user as $k => $v) {
                    $likes[] = Redis::hmget('question_user_like_'.$id.'_'.$v, 'user_id','user_name','user_avatar');

            }
        }

        return view('questions.show',compact('data','likes','count'));

    }


    public function destroy($id)
    {

        $question = $this->questionRepository->getById($id);

        if(!$question && !authUser()->owns($question)){
            return back();
        }

        event(new QuestionsDelEvent($question));//删除问题文章前触发的操作



        $question->delete();
        return redirect()->route('questions.index');

    }



}
