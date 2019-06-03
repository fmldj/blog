<?php
namespace App\Repositories;

use Auth;
use App\Model\Answer;
use App\Model\Comment;
use App\Model\Question;

class CommentRepository
{

	// 获得答案的评论
	public function getAnswerComment($id)
	{
    	$comment = Answer::with(['comments', 'comments.user'])->where('id', $id)->first();
		$comments = Comment::_getSon($comment->comments->toArray(),0);
		return $comments;
	}

	// 获得问题的评论
	public function getQuestionComment($id)
	{
    	$comment = Question::with(['comments', 'comments.user'])->where('id', $id)->first();
    	$comments = Comment::_getSon($comment->comments->toArray(),0);
    	return $comments;
	}

	// 评论提交（对问题的评论 OR 对答案的评论）
	public function store($request)
	{
    	$model = $this->getTypeModel($request->get('type'));
        $commentable_id = $request->get('model');
    	$comment = Comment::create([
    		'user_id' => Auth::guard('api')->user()->id,
    		'body' => $request->get('body'),
    		'commentable_id' => $commentable_id,
    		'parent_id' => 0,
    		'commentable_type' => $model,
    	]);
    	return compact('model','comment');

	}

	// 用户多级评论
	public function plStore($request)
	{
    	$model = $this->getTypeModel($request->get('type'));
        $commentable_id = $request->get('model');
    	$comment = Comment::create([
    		'user_id' => Auth::guard('api')->user()->id,
    		'body' => $request->get('pl_body'),
    		'parent_id' => $request->get('parent_id'),
    		'commentable_id' => $commentable_id,
    		'commentable_type' => $model,
    	]);
    	return compact('model','comment');
	}

    public function getTypeModel($type)
    {	
    	return $type == 'question' ? 'App\Model\Question' : 'App\Model\Answer';
    }


}