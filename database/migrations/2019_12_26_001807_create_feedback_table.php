<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){}
//     {
//         Schema::create('feedback', function (Blueprint $table) {
//             // $table->bigIncrements('id');

//             // $table->unsignedBigInteger('tournament_ID');
//             // $table->foreign('tournament_ID')->references('id')->on('tournaments');
            
//             // $table->unsignedBigInteger('user_ID');
//             // $table->foreign('user_ID')->references('id')->on('tournaments');
                    
//             // $table->unsignedBigInteger('arcade_ID');
//             // $table->foreign('arcade_ID')->references('id')->on('arcades');

//             // $table->enum('How_did_you hear_',
//             //  ['Direct Outreach from VAL or VAL discord','Game Developers','Springboard','Other VR Arcades','other']);

//             // $table->enum('Why_You_Participated',
//             //  ['The prizes!',
//             //  'It brings in more local business for my arcade',
//             //  'I wanted to connect with other arcade owners','To be part of a larger community',
//             //  'I wanted the chance to try a new game',
//             //  'other']);

//             // $table->boolean('Did_you_own_the_game_before');

//             // $table->enum('Pro',
//             //  ['The prizes!',
//             //  'Basic (Springboard)',
//             //  'Trial Keys for Pro']);
//             // $table->boolean('Increase in Game usage');

//             // $table->string('what_you_enjoy_tournament');
//             // $table->string('what_you_enjoy_game');
//             // $table->json('I_enjoyed_this_about_the_tournament');
//             // $table->string('what_you_enjoy_game');
//             // $table->string('what_changes_you_make');
//             // $table->boolean('Do_you_have_a_fullsetup for_game');
//             // $table->boolean('Are_you_Interested)fullsetup for_game');
//             // $table->enum('Importance_Prop_time',['1','2','3','4']);
//             // $table->enum(
//             //     'Weeks_Ideal_Notice',
//             //  ['2 weeks or less','3 weekss',
//             //  '4 weeks to 6 weeks',
//             //  '6 weeks to 8 weeks',
//             //  'longer then 8 weeks']);
//             // $table->boolean('More_time_to_prep');
//             // $table->string('How_more_time_would_help');
//             // $table->boolean('Any_audio_issues');

//             // $table->boolean('Any_droped_players');
//             // $table->boolean('Any_other_game_issues');
//             // $table->string('what_bug_issue');
//             // $table->json('Future_Games_most_Interesed');
//             // $table->boolean('Would_you_participate');
//             // $table->boolean('Did you register new app');
//             // $table->boolean('Beta_Interest');
//             // $table->string('Improvments_to_VAL');
//             // $table->enum('interest_League_Nights',['Yes','No','Maybe']);
//             // $table->string('Improvments_to_VAL_Tournament');
//             // $table->string('Improvments_to_the_game');
//             // $table->string('Comments_Pricing');

//             // $table->timestamps();
//         // });
//     // });
// });
// }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
