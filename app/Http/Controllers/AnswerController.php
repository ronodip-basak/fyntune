<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function markAsSelected(Answer $answer){
        if($answer->question->is_answered){
            return [
                'error' => 'The Question has already been answered!'
            ];
        }

        $answer->selected_by_user = true;
        $answer->save();
        $question = $answer->question;
        $question->is_answered = true;
        $question->save();
        $correct_answers = $answer->question->correctAnswer;


        return $correct_answers;
    }
}
