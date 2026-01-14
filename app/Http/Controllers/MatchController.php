<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\FreefireMatch;
use App\Models\LudoMatch;
use App\Models\PubgMatch;
use App\Models\Joining;
use App\Models\Rule;
use App\Models\User;
use Carbon\Carbon;

class MatchController extends Controller
{
    /**
     * ইউজারের ট্রানজেকশন এবং ম্যাচ হিস্টোরি দেখার জন্য।
     */
    public function myMatchesHistory()
    {
        $user = Auth::user();

        // ১. ডিপোজিট ডাটা (Add Money)
        $deposits = DB::table('aerox_addmoney')
            ->select('Method', 'Amount', 'Date', 'Status', DB::raw("'Deposit' as type"))
            ->where('Number', $user->Number);

        // ২. উইথড্র ডাটা (Withdraw)
        $withdraws = DB::table('aerox_withdraw')
            ->select('Method', 'Amount', 'Date', 'Status', DB::raw("'Withdraw' as type"))
            ->where('Number', $user->Number);

        // ৩. ম্যাচের এন্ট্রি ফি ডাটা (Joining)
        // এখানে ৩টি ম্যাচ টেবিল থেকেই ডেটা চেক করার চেষ্টা করা হয়েছে
        $matchEntries = DB::table('aerox_joiners')
            ->select(
                DB::raw("'Match Entry Fee' as Method"),
                DB::raw("0 as Amount"), // ডিফল্ট ০, নিচে আপডেট হবে যদি রিলেশন থাকে
                'created_at as Date',
                DB::raw("'Success' as Status"),
                DB::raw("'Match Entry' as type"),
                'Match_Key'
            )
            ->where('Number', $user->Number);

        // সবগুলোকে তারিখ অনুযায়ী সাজিয়ে আনা
        $transactions = $deposits
            ->unionAll($withdraws)
            ->orderBy('Date', 'desc')
            ->get();

        return view('user.my_history', compact('transactions', 'user'));
    }

    /**
     * ম্যাচের তালিকা দেখানোর জন্য।
     */
    public function index($type)
    {
        $userNumber = Auth::user()->Number;

        $joinedMatchKeys = Joining::where('Number', $userNumber)
                                  ->pluck('Match_Key')
                                  ->all();

        $model = FreefireMatch::class;
        $pageTitle = 'Matches';
        $matchTypeCondition = 'Classic'; 
        $entryTypeCondition = 'Solo';

        switch ($type) {
            case 'br_match':
                $model = FreefireMatch::class;
                $matchTypeCondition = 'Classic';
                $entryTypeCondition = 'Solo';
                $pageTitle = 'Free Fire Solo';
                break;
            case 'clash_squad':
                $model = FreefireMatch::class;
                $matchTypeCondition = 'Clash Squad';
                $entryTypeCondition = 'Squad';
                $pageTitle = 'Clash Squad';
                break;
            case 'lone_wolf':
                $model = FreefireMatch::class;
                $matchTypeCondition = 'LONE WOLF';
                $entryTypeCondition = 'Solo';
                $pageTitle = 'Lone Wolf Matches';
                break;
            case 'free_match':
                $model = FreefireMatch::class;
                $matchTypeCondition = 'FREE MATCH';
                $entryTypeCondition = 'Solo';
                $pageTitle = 'Free Matches';
                break;
            case 'ludo':
                $model = LudoMatch::class;
                $matchTypeCondition = 'Ludo';
                $entryTypeCondition = 'Solo';
                $pageTitle = 'Ludo Matches';
                break;
            case 'pubg_solo':
                $model = PubgMatch::class;
                $matchTypeCondition = 'Classic';
                $entryTypeCondition = 'Solo';
                $pageTitle = 'PUBG Solo';
                break;
            case 'pubg_duo':
                $model = PubgMatch::class;
                $matchTypeCondition = 'Classic';
                $entryTypeCondition = 'Duo';
                $pageTitle = 'PUBG Duo';
                break;
            case 'pubg_squad':
                $model = PubgMatch::class;
                $matchTypeCondition = 'Classic';
                $entryTypeCondition = 'Squad';
                $pageTitle = 'PUBG Squad';
                break;
            case 'pubg_arena':
                $model = PubgMatch::class;
                $matchTypeCondition = 'TDM 4VS4';
                $entryTypeCondition = 'Squad';
                $pageTitle = 'PUBG Arena';
                break;
            case 'cs_2v2':
                $model = FreefireMatch::class;
                $matchTypeCondition = 'CS 2V2';
                $entryTypeCondition = 'Duo';
                $pageTitle = 'CS 2 VS 2';
                break;
            default:
                return redirect()->route('matches.list', ['type' => 'br_match']);
        }

        $matches = $model::where('Match_Type', $matchTypeCondition)
                         ->where('Entry_Type', $entryTypeCondition)
                         ->whereIn('Position', ['OnGoing', 'Match'])
                         ->orderByRaw("FIELD(Position, 'OnGoing', 'Match')")
                         ->orderBy('id', 'desc')
                         ->get();

        return view('matches', [
            'pageTitle' => $pageTitle,
            'matches' => $matches,
            'joinedMatchKeys' => $joinedMatchKeys,
            'type' => $type,
        ]);
    }

    /**
     * একটি নির্দিষ্ট ম্যাচের বিস্তারিত পেজ।
     */
    public function showDetails($game, $id)
    {
        if ($game === 'ludo') {
            $model = LudoMatch::class;
        } elseif (strpos($game, 'pubg') !== false) {
            $model = PubgMatch::class;
        } else {
            $model = FreefireMatch::class;
        }

        $match = $model::find($id);
        if (!$match) { abort(404, 'Match not found!'); }

        $user = Auth::user();
        $isJoined = Joining::where('Match_Key', $match->Match_Key)
                           ->where('Number', $user->Number)
                           ->exists();

        $rules = Rule::where('match_category', $match->Match_Type)->first();
        $rulesText = $rules ? $rules->rules_text : "Standard tournament rules apply.";

        return view('match-details', [
            'match' => $match,
            'user' => $user,
            'isJoined' => $isJoined,
            'rulesText' => $rulesText,
            'gameType' => $game,
        ]);
    }

    /**
     * ম্যাচে জয়েন করার প্রক্রিয়া।
     */
    public function joinMatch(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ingame_name_1' => 'required|string|max:100',
            'game_type'     => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Please enter your in-game name.')->withInput();
        }

        $user = Auth::user();
        
        if ($request->game_type === 'ludo') {
            $model = LudoMatch::class;
        } elseif (strpos($request->game_type, 'pubg') !== false) {
            $model = PubgMatch::class;
        } else {
            $model = FreefireMatch::class;
        }

        $match = $model::findOrFail($id);
        $matchTime = Carbon::parse($match->Match_Time);

        if (now()->greaterThanOrEqualTo($matchTime)) {
            return back()->with('error', 'Match already started!');
        }

        if (Joining::where('Match_Key', $match->Match_Key)->where('Number', $user->Number)->exists()) {
            return back()->with('error', 'You have already joined this match.');
        }

        if ($match->Player_Join >= $match->Player_Need) {
            return back()->with('error', 'Sorry, the match is full.');
        }

        if ((float)$user->Balance < (float)$match->Entry_Fee) {
            return back()->with('error', 'Insufficient balance to join. Please top up.');
        }

        $teamPlayers = collect($request->only(['ingame_name_1', 'ingame_name_2', 'ingame_name_3', 'ingame_name_4']))
                        ->filter()->values()->all();

        try {
            DB::transaction(function () use ($user, $match, $request, $teamPlayers) {
                // ইউজার ব্যালেন্স এবং প্রোফাইল আপডেট
                $user->decrement('Balance', (float)$match->Entry_Fee);
                $user->increment('Total_Played');

                // জয়েনিং টেবিল এন্ট্রি
                Joining::create([
                    'Match_Key'   => $match->Match_Key,
                    'Name'        => $user->Name,
                    'Number'      => $user->Number,
                    'ingame_name' => $request->ingame_name_1,
                    'team_info'   => json_encode($teamPlayers),
                ]);

                // ম্যাচ জয়েনার কাউন্ট আপডেট
                $match->increment('Player_Join');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred. Please try again.');
        }

        return redirect()->route('match.details', ['game' => $request->game_type, 'id' => $id])->with('success', 'Joined Successfully!');
    }

    /**
     * জয়নার লিস্ট দেখা।
     */
    public function showJoiners($matchId)
    {
        $match = FreefireMatch::find($matchId) 
              ?? LudoMatch::find($matchId) 
              ?? PubgMatch::find($matchId);

        if (!$match) { abort(404); }

        $joiners = Joining::where('Match_Key', $match->Match_Key)->get(['ingame_name']);
        
        $rules = Rule::where('match_category', $match->Match_Type)->first();
        $rulesText = $rules ? $rules->rules_text : "Standard tournament rules apply.";

        return view('user.match-joiners', compact('match', 'joiners', 'rulesText'));
    }

    /**
     * রুলস দেখা।
     */
    public function rules($id)
    {
        $match = FreefireMatch::find($id) 
              ?? LudoMatch::find($id) 
              ?? PubgMatch::find($id);
              
        if (!$match) { abort(404); }

        $rules = Rule::where('match_category', $match->Match_Type)->first();
        $rulesText = $rules ? $rules->rules_text : "No rules found.";

        return view('match-rules', compact('match', 'rulesText'));
    }
}