<?php
namespace App\Traits;
use App\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

trait todoCreation
{
    public function createTasks($uid,$tid)
    {
  // logic here
  // user and tournament info
  $userID = $uid;
  $tournamentID = $tid;
  // Tiles indidual so we can tweak later easily and possible translations in the future
$title1 = "Prepare 2 Weeks Advance";
$title2 = "Print Setup";
$title3 = "Deposit Notification";
$title4 = "Invite Local Gaming Community";
$title5 = "Social Media Aware";
$title6 = "Make it a Party";
$title7 = "Have Extra stuff";
$title8 = "Side Entertainment";
$title9 = "Rules of Engagment Play";
$title10 = "Record Top Score";
$title11 = "Document Everything";
$title12 = "Email Collection";
$title13 = "Invite To Join Social Channels";
$title14 = "Gather Phone Numbers";
$title15 = "Post Tournament Results";

$cat1 = "Prep";
$cat2 = "Prep";
$cat3 = "Prep";
$cat4 = "Marketing";
$cat5 = "Marketing";
$cat6 = "Marketing";
$cat7 = "Marketing";
$cat8 = "Marketing";
$cat9 = "Document";
$cat10 = "Document";
$cat11 = "Document";
$cat12 = "Post";
$cat13 = "Post";
$cat14 = "Post";
$cat15 = "Post";

// Descriptiosn of tasks same pattern as above
$desc1 = "For any tournament its critical to start preparing at least two weeks in advance. Retail staff are your troubleshooters, salespeople, and VR evangelists to your customers. They will be doing the day to day work and will be key for a successful event. Talk to your staff about the goals of the tournament.";
$desc2 = "Put up a sign advertising the who, what, when of the tourney - preferably right by the register. Studies from game developers have shown that having posters of game content up in your arcade does a few things. It increases your overall conversion in the store, and then it increases the conversion of that title specifically. For example if you have a poster up of Raw Data, then more people will purchase time in the arcade vs if you had a blank wall, and two, more people will play Raw Data. It seems obvious, but it's also backed by data. This applies to upcoming events.";
$desc3 = "​At Virtualities, we always aim for at least 50% of the tournament sales to be “pre-sales”. From talking to local comiccon conventions, if you can get at least 50% of the tickets sold beforehand you will have a successful event. For most arcades, this is a simple upsell at the register. When they pay, ask if they want to pay to participate in the upcoming tournament, and talk about the prizes, the game etc. Explain that the only way to guarantee that they will get a spot will be sign up before. We noticed that getting arcade guests to commit this way was much more successful than a simple sign up sheet.";
$desc4 = "Those are just the in store sales. You will also get a lot of traction from letting other people know. A lot of gaming communities are already organized in every city. For instance, at one of our recent tournaments we had participants from the University of Utah gaming club and the Utah VR meetup group. There are over 40 VR meetup groups across the country. Additionally, we are also active participants in a number of discord servers focused around Twitch as well as in esports at local universities and we announce our tournaments in those places as well.";
$desc5 = "Make a social post on your facebook/insta/twitter and if you regularly boost your facebook pages, spend a few dollars to get a bit more visibility into it. We have found facebook to be one of our best platforms for ROI. We also collect emails during our active waiver signup process and typically get a couple of people that sign up with an email blast.";
$desc6 = "​During our events we try to make it as much of a party atmosphere as possible. Crank up the radio, bring in pizza or other snacks, and bring out your special lighting!";
$desc7 = "​For people to run the tournament we typically find we can also supplement arcade staff with volunteers, which will help you run a profitable event. Volunteers can be those who have participated in past tournaments, or family or friends who are down for some free pizza and VR.";
$desc8 = "​One key thing we learned from the University of Utah gaming events was the importance of side activities. In addition to food, bring in a N64 on the side or something for people to bond over while they wait their turn or watch. Have a board game corner. Building those connections between people is not only key for you as an arcade owner, people start to show up to tournaments again because you are doing something of real value to them- you are creating a community, real life friendships, and a place to celebrate VR.";
$desc9 = "​During the tournament carefully explain the rules to people beforehand.";
$desc10 = "​Have staff to watch the high scores. In our national Blasters of the Universe tournament we took screenshots of the high scores in our high score competition. For Sprint Vector, we did a single elimination bracket tournament,and the tension would build as the finalists got closer. For your last two competitors people gather around for the final head to head. It can be quite intense, as spectators eyes are fixed on the two athletes, every single score counts, and the stress levels ratchet up. It's like the olympics but in VR.";
$desc11 = "​Film it, because both you and everyone there will want to remember it - well the winners anyways! But even those who don’t win it its lights a real competitive fire.";
$desc12 = "Gather the emails​ and start to build a list of the regulars. For prize allocation this matters too, since building trust is a critical esports principle.";
$desc13 = "Invite to join​ your Discord or Facebook group";
$desc14 = "Gather phone numbers: ​We found that getting the phone numbers of our regulars allowed us to send out group texts and get a few future sign ups easily.";
$desc15 = "Post tournament results up on social media​ as well as a clip of what happened as way to build buzz.";

for($i = 1; $i<=15; $i++) {

  $titleVar = 'title'.$i;
  $catVar = 'cat'.$i;
  $descVar = 'title'.$i;
      $taskCreation = Todo::create([
      'title' => $$titleVar,
      'user_ID' => $userID,
      'tournament_ID'=> $tournamentID,
      'category'=> $$catVar,
      'status'=> 'todo',
      'description' => $$descVar]);
}
}

}
