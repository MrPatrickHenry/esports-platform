<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

protected $table = 'feedback';
protected $fillable = [
'tournament_ID',
'user_ID',
'arcade_ID',
'How_did_you hear_',
'Why_You_Participated',
'Did_you_own_the_game_before',
'Pro',
'what_you_enjoy_tournament',
'what_you_enjoy_game',
'I_enjoyed_this_about_the_tournament',
'what_changes_you_make',
'Do_you_have_a_fullsetup for_game',
'Are_you_Interested)fullsetup for_game',
'Importance_Prop_time',
'Weeks_Ideal_Notice',
'More_time_to_prep',
'How_more_time_would_help',
'Any_audio_issues',
'Any_droped_players',
'Any_other_game_issues',
'what_bug_issue',
'Future_Games_most_Interesed',
'Would_you_participate',
'Did you register new app',
'Beta_Interest',
'Improvments_to_VAL',
'interest_League_Nights',
'Improvments_to_VAL_Tournament',
'Improvments_to_the_game',
'Comments_Pricing'
];
}
