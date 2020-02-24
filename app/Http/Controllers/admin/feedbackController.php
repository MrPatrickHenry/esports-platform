<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;
use App\Traits\apiResponse;

class feedbackController extends Controller
{
    use apiResponse;

    public function index()
    {
        $FeedbackList = Feedback::all();
        return $this->responseAPI($FeedbackList);
    }

    public function store(Request $request)
    {
        $Feedback = Feedback::create([
            'tournament_ID' => $request->tournament_ID,
            'user_ID' => $request->user_ID,
            'arcade_ID'=> $request->arcade_ID,
            'How_did_you_hear'=> $request->How_did_you_hear,
            'Why_You_Participated' => $request->Why_You_Participated,
            'Did_you_own_the_game_before' => $request->Did_you_own_the_game_before,
            'Increase_in_Game_usage' => $request->Increase_in_Game_usage,
            'what_you_enjoy_tournament' => $request->what_you_enjoy_tournament,
            'I_enjoyed_this_about_the_tournament'=> $request->I_enjoyed_this_about_the_tournament,
            'what_changes_you_make'=>$request->what_changes_you_make,
            'Do_you_have_a_fullsetup_for_game'=>$request->Do_you_have_a_fullsetup_for_game,
            'Are_you_Interested_fullsetup_for_game'=>$request->Are_you_Interested_fullsetup_for_game,
            'Importance_Prop_time' =>$request->Importance_Prop_time,
            'Weeks_Ideal_Notice'=>$request->Weeks_Ideal_Notice,
            'More_time_to_prep'=>$request->More_time_to_prep,
            'How_more_time_would_help'=>$request->How_more_time_would_help,
            'Any_audio_issues'=>$request->Any_audio_issues,
            'Any_droped_players'=>$request->Any_droped_players,
            'Any_other_game_issues' => $request->Any_other_game_issues,
            'what_bug_issue'=>$request->what_bug_issue,
            'Future_Games_most_Interesed' => $request->Future_Games_most_Interesed,
            'Would_you_participate' =>$request->Would_you_participate,
            'Did_you_register_new_app'=>$request->Did_you_register_new_app,
            'Beta_Interest'=>$request->Beta_Interest,
            'Improvments_to_VAL'=>$request->Improvments_to_VAL,
            'interest_League_Nights'=>$request->interest_League_Nights,
            'Improvments_to_VAL_Tournament'=>$request->Improvments_to_VAL_Tournament,
            'Improvments_to_the_game'=>$request->Improvments_to_the_game,
            'Comments_Pricing'=>$request->Comments_Pricing,

            'public'=>'0',
        ]);
        return $this->responseAPI($Feedback);
    }

    public function show(Request $request)
    {
        $showFeedback = Feedback::findorfail($request->id)->get();
        return $this->responseAPI($showFeedback);
    }
}
