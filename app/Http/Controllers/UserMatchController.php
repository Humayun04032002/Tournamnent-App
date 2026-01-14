<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserMatchController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userNumber = $user->Number;

        // ১. সব গেমের ম্যাচ কোয়েরি (ইউনিয়ন করার জন্য)
        $freefireMatches = DB::table('aerox_freefire')
            ->select('Match_Key', 'Match_Title', 'Match_Time', 'Entry_Fee', 'Entry_Type', 'Position', 'Room_ID', 'Room_Pass');

        $pubgMatches = DB::table('aerox_pubg')
            ->select('Match_Key', 'Match_Title', 'Match_Time', 'Entry_Fee', 'Entry_Type', 'Position', 'Room_ID', 'Room_Pass');

        $ludoMatches = DB::table('aerox_ludo')
            ->select('Match_Key', 'Match_Title', 'Match_Time', 'Entry_Fee', 'Entry_Type', 'Position', 'Room_ID', 'Room_Pass');

        $allMatchesBase = $freefireMatches->unionAll($pubgMatches)->unionAll($ludoMatches);

        // ২. ইউজারের খেলা ম্যাচের লিস্ট (PLAYED MATCHES ট্যাব এর জন্য)
        // এখানে 'j.Date' এর বদলে 'j.time' ব্যবহার করা হয়েছে এরর ফিক্স করার জন্য
        $playedMatches = DB::table('aerox_joining as j')
            ->joinSub($allMatchesBase, 'm', function ($join) {
                $join->on('j.Match_Key', '=', 'm.Match_Key');
            })
            ->where('j.Number', $userNumber)
            ->select('m.*', 'j.winnings', 'j.position as joining_position', 'j.time as Join_Date')
            ->orderBy('m.Match_Time', 'desc')
            ->get();

        // ৩. ট্রানজেকশন কোয়েরি (শুধুমাত্র ম্যাচ জয়েনিং ফি এবং উইনিং)

        // ক. ম্যাচ জয়েনিং ফি (মাইনাস হবে)
        $matchFees = DB::table('aerox_joining as j')
            ->joinSub($allMatchesBase, 'm', function ($join) {
                $join->on('j.Match_Key', '=', 'm.Match_Key');
            })
            ->select(
                DB::raw("CONCAT('Joined: ', m.Match_Title) as Method"), 
                'm.Entry_Fee as Amount', 
                'j.time as Date', 
                DB::raw("'MatchFee' as type")
            )
            ->where('j.Number', $userNumber);

        // খ. ম্যাচ উইনিং (প্লাস হবে)
        $matchWinnings = DB::table('aerox_joining as j')
            ->joinSub($allMatchesBase, 'm', function ($join) {
                $join->on('j.Match_Key', '=', 'm.Match_Key');
            })
            ->select(
                DB::raw("CONCAT('Won: ', m.Match_Title) as Method"), 
                'j.winnings as Amount', 
                'j.time as Date', 
                DB::raw("'Winning' as type")
            )
            ->where('j.Number', $userNumber)
            ->where('j.winnings', '>', 0);

        // শুধুমাত্র ম্যাচ ফি এবং উইনিং গুলোকে একসাথে করে সাজানো
        $allTransactions = $matchFees->unionAll($matchWinnings)
            ->orderBy('Date', 'desc')
            ->get();

        return view('my-matches', [
            'playedMatches'  => $playedMatches,
            'transactions'   => $allTransactions, 
        ]);
    }
}