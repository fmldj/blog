<?php

namespace App\Http\Controllers;

use stdClass;
use App\Question;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;

class SearchController extends BaseController
{
    public function index(Request $request)
    {


		$q = $request->get('q');
		if(!$q){
			$questions = array();

		}else{
		    	$params = [
		    			'index' => 'blog',
		    			'type' => '_doc',
			    		'body' => [
					    		'query' => [
					    			'multi_match' => [
					    				'query' => $q,
					    				'fields' => ['question_body'],
					    				// 'type' => 'phrase',
					    				// 'slop' => 10
					    			],
					    		],


								'highlight' => [
									"require_field_match" => true,
				                    'pre_tags' => ["<span style='color:red'>"],
				                    'post_tags' => ["</span>"],
							        "fragment_size"  => 10000,
							        "number_of_fragments"  => 10000,
							        "no_match_size" => 1,
					                'fields' => [
					                    'question_body' => new stdClass(),
					                    // 'question_title' => new stdClass(),


					                ],
					            ],



			    		]

		    	];
		    	

		    	$client= ClientBuilder::create()->setHosts(['http://94.191.70.63:32369'])->build();
		    	$questions = $client->search($params);
		}

    	// dd($questions);
    	return view('search.index',compact('questions','q'));
    }
}
