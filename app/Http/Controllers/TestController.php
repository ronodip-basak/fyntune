<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function startTest(Request $request){
        //Start the mcq Test
        //For guest user

        $test = Test::create([]);

        session(['current_test' => $test->id]);

        $this->fetchQuestions($test);

        return redirect(route('test.index', $test));
    }

    public function index(Test $test){
        if($test->is_completed){
            return redirect(route('test.showResult', $test));
        }
        return view('public.question', [
            'test' => $test
        ]);
    }

    public static function fetchQuestions(Test $test){
        $url = 'https://opentdb.com/api.php?amount=10';
        //maybe put the url in some other place for an actual project XD
        $response = Http::get($url)->json();


        foreach($response['results'] as $question){
            $myQuestion = new Question();
            $myQuestion->test_id = $test->id;
            $myQuestion->question = $question['question'];
            $myQuestion->difficulty = $question['difficulty'];
            $myQuestion->type = $question['type'];

            $myQuestion->save();

            $answers_to_save = [];
            foreach($question['incorrect_answers'] as $answer){
                array_push($answers_to_save, new Answer([
                    'option_value' => $answer
                ]));
            }
            array_push($answers_to_save, new Answer([
                'option_value' => $question['correct_answer'],
                'is_correct' => true
            ]));

            $myQuestion->answers()->saveMany($answers_to_save);
        }
    }

    public function returnQuestions(Test $test){
        $questions = $test->questions;

        return QuestionResource::collection($questions);
    }

    public function showResult(Test $test){
        return view('public.result', [
            'test' => $test
        ]);
    }

    public function adminIndex(Request $request){
        $orderBy = $request->order_by;
        $order_type = $request->order_type;

        // dd($order_type);

        $tests = Test::with('user')->when($orderBy, function($query, $orderBy) use ($order_type) {
            if($order_type != null){
                return $query->orderBy($orderBy, $order_type);
            }
            return $query->orderBy($orderBy);
        })->paginate(5);

        
        return view('admin.index', [
            'tests' => $tests
        ]);
    }
}
