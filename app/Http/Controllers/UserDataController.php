<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\Test;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function saveResult(Test $test, Request $request){
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10'
        ]);

        $validatedData['test_id'] = $test->id;

        $userData = UserData::create($validatedData);

        $recieved_score = 0; // initial value

        $test->load('questions.selectedAnswer');

        foreach($test->questions as $question){
            if($question->selectedAnswer->is_correct){
                $recieved_score++;
            }
        }

        $test->score_recieved = $recieved_score;
        $test->total_score = count($test->questions);
        $test->is_completed = true;
        $test->save();

        $request->session()->forget('current_test');

        return redirect(route('test.showResult', $test));
    }

    public function search(Request $request){
        $userData = UserData::where('name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
            ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
            ->with('test')->get();

        return $userData;
    }
}
