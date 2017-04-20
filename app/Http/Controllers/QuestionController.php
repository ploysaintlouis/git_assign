<?php

namespace App\Http\Controllers;

use View;

use App\Http\Requests\QuestionFormRequest;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\models\Question;
use App\models\TestCase;

class QuestionController extends BaseController {

    public function createQuestion($assignment_id) {
        return View::make('questionCreate', array('assignment_id' => $assignment_id));
    }

	public function editQuestion($id)
    {
        $question  = Question::find($id);
		$testCases = TestCase::find($id);
		
        return View::make('questionEdit', compact('question','testCases'));
    }
	
    public function saveQuestion(QuestionFormRequest $request,$assignment_id) {
		
        $question = new Question;
		$question->assignment_id = $assignment_id;
        $question->name = $request->name;
        $question->description = $request->description;
		$question->guideline = $request->guideline;
		$question->score = $request->score;
        $question->active = $request->status == "Open";        
        $question->deleted = false;
        $question->save();
		
		return redirect('editQuestion/'.$question->id);
		
    }

	public function update(QuestionFormRequest $request,$id){
		
        $question  = question::find($id);
		
        $question->name = $request->name;
        $question->description = $request->description;
		$question->guideline = $request->guideline;
		$question->score = $request->score;
        $question->active = $request->status == 'ACTIVE' ? 1 : 0;  
		
        $question->save();
		
        return redirect('editQuestion/'.$question->id);
    }
	
	public function delete($id){
		
		$question = question::destroy($id);
	
        return redirect()->back();
    }
	
}

?>
