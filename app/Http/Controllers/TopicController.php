<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Topic;
use App\Model\Dynamic;
use Illuminate\Http\Request;
use App\Repositories\TopicRepository;
use App\Events\TopicEvent;


class TopicController extends BaseController
{
    protected $topicRepository;

    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->middleware('auth')->except(['index','following','info','getTopicQuetion']);
    }


    // 话题广场
    public function index()
    {

        $topics = $this->topicRepository->getAllTopicData();
        return view('topic.index',compact('topics'));

    }


    // 用户关注某个话题
    public function following(Request $request)
    {

            $user = authApiUser();
            $topic_id = $request->get('topic_id');
            $res = $user->followTopicAction($topic_id);

            // 关注（取消）话题之后操作
            $status = event(new TopicEvent($res, $topic_id));

            return ['status' => $status[0]['status']];


    }

    // 话题详情
    public function info($topic_id)
    {
        $topic = $this->topicRepository->getById($topic_id);
        $count = $this->topicRepository->getTopicFollowedUserCount($topic_id);

        return view('topic.info', compact('topic','count'));
    }








    // 搜索话题获得对应的主题列表
    public function getTopicQuetion($topic_id)
    {
        $res = $this->topicRepository->getTopicQuetion($topic_id);

        return ['data' => $res];
    }


}
