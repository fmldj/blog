<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Events\CommentEvent;
use App\Repositories\CommentRepository;



class CommentController extends BaseController
{

    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }


    public function answer($id)
    {
        $comments = $this->commentRepository->getAnswerComment($id);

    	return $comments;
    }

    public function question($id)
    {
        $comments = $this->commentRepository->getQuestionComment($id);

    	return $comments;
    }




    // 用户评论
    public function store(Request $request)
    {
        $data = $this->commentRepository->store($request);
        // 用户评论之后的触发的事件
        event(new CommentEvent($data,$request->get('model')));

    	return $data['comment'];
    	
    }


    // 用户多级评论
    public function pl(Request $request)
    {
        $data = $this->commentRepository->plStore($request);
        $res = event(new CommentEvent($data,$request->get('model'),$data['comment']->parent_id));


    	return ['comments' => $res[0]['comments'], 'parent_name' => $res[0]['parent_name']];
    }
    

}
