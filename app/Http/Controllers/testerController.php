<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Test;
use App\Models\Chat;
use App\Models\Result;

class testerController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()) {
            if(isset($request->getChatInfo)) {
                $latest = Chat::orderBy('id', 'desc')->first();
                $chat = Chat::Where('id', '>', $latest->id - 5)->get();
                return response()->json(['chats' => $chat]);
            } else {
                $chat = New Chat;
                $chat->author = $request->user()->name;
                $chat->text = $request->inputText;
                $chat->save();
                return response()->json(['chats' => $chat]);
            }
        }
        
        $tests = Test::with('results')->get()->sortByDesc(function($test) {
            return $test->results->count();
        })->take(14);

        if(count(Test::Where('title', $request->search)->get()) > 0) {
            $test = Test::Where('title', $request->search)->get();
            return redirect()->route('test.view', ['id'=>$test[0]->id]);
        } elseif(isset($request->search)) {
            $request->session()->flash('status', 'Test does not exist!');
            return redirect()->route('test.search');  
        }
        return view('home', ["tests"=>$tests]);
    }

    public function testCreateGet() {
        //$arr = ['a'=>23, 'b'=>25];
        //$test1 = json_encode($arr);
        //echo response()->json($test1);
        return view('testCreateView');
    }

    public function testCreatePost(Request $request) {
        $test = new Test;

        if($request->hasPass)
        {
            $validated = $request->validate([
                'title'=>'required|unique:tests|max:30',
                'content'=>'required|max:255',
                'pass' => 'required|max:20'
            ]);
            $test->password = $request->pass;
        } else {
            $validated = $request->validate([
                'title'=>'required|unique:tests|max:30',
                'content'=>'required|max:255'
            ]);
        }

        $test->title = $request->title;
        $test->content = $request->content;
        $test->author = $request->user()->name;
        $test->has_password = $request->hasPass;
        $arr = explode("~F", $request->answ);
        $answers = [];
        foreach($arr as $value)
        {
            $value = explode("~D", $value);
            foreach($value as $val)
            {
                array_push($answers, $val);
            }
        }
        $test->answers = json_encode($answers);
        $test->search = $request->title; //I don't know!
        $test->save();
        $request->session()->flash('status', "You have successfully created a test ");
        $request->session()->flash('search', $test->search); //implode(", ", $answers)
    }

    public function testSearchGet(Request $request) {
        if(isset($request->search)) {
            $findTests = Test::where('title', 'LIKE', '%'.$request->search.'%')->get();
            return view('search', ["tests" => $findTests]); 
        }
        $tests = Test::all();
        return view('search', ["tests" => $tests]);
    }

    public function testViewGet($id) {
        $test = Test::where("id", $id)->get();
        $allAnswers = json_decode($test[0]->answers, true);
        return view('testView', ["test"=>$test[0], 'answers'=>$allAnswers]);
    }

    public function testViewPost(Request $request, $id) {
        $test = Test::find($id);
        $true = 0;
        $FalseAnswers = '';

        if($request->ajax()) {
            if($request->pass == $test->password){
                return response()->json(['status'=>true]);
            } else {
                return response()->json(['status'=>false, 'pass'=>$test->password]);
            }
        } else {
            if(isset($request->answer1)) {
                $result = new Result;

                $answers = json_decode($test->answers, true);
                for($i=3, $j=1; $i<count($answers); $i+=8, $j++){
                    if ($answers[$i] == ($request->all())['answer' . (string)$j]) {
                        $true++;
                    }
                }

                $result->title = $test->title;
                $result->user = $request->user()->name;
                $result->answers_count = $answers[count($answers)-8];
                $result->true_answers_count = $true;
                $test->results()->save($result);
                
                $request->session()->flash('status', 'You answered correctly ' . $true . ' of ' . $answers[count($answers)-8] . ' (' . round(($true * 100) / $answers[count($answers)-8]) . '%)');
                return redirect()->route('test.info', ['id'=>$id]);
            } else {
                $request->session()->flash('status', 'You have not answered any questions');
                return redirect()->route('test.info', ['id'=>$id]);
            }
        }
    }

    public function testInfoView($id) {
        $test = Test::where('id', $id)->get();
        return view('info', ['test'=>$test[0]]);
    }

    public function faqView() {
        return view('FAQ');
    }

    public function resultView(Request $request, $id) {
        $test = Test::find($id);
        $results = $test->results;
        return view('result', ['title'=>$test->title, 'results'=>$results, 'count'=>count($results)]);
    }
}
