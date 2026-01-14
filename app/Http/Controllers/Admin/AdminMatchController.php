<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FreefireMatch;
use App\Models\LudoMatch;
use App\Models\PubgMatch; 
use App\Models\AdminSetting;
use App\Models\Joining;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Traits\SendsFirebaseNotifications;
use Carbon\Carbon;

class AdminMatchController extends Controller
{
    use SendsFirebaseNotifications;

    /**
     * গেম টাইপ অনুযায়ী মডেল ইন্সট্যান্স রিটার্ন করে।
     */
    private function getModelInstance(string $game_type)
    {
        return match ($game_type) {
            'freefire' => new FreefireMatch(),
            'ludo'     => new LudoMatch(),
            'pubg'     => new PubgMatch(), 
            default    => abort(404, 'Invalid game type specified.'),
        };
    }

    /**
     * আইডি অনুযায়ী ম্যাচ খুঁজে বের করে।
     */
    private function findMatchById(string $game_type, $id)
    {
        return $this->getModelInstance($game_type)->findOrFail($id);
    }

    /**
     * সব বিদ্যমান টেবিল থেকে ম্যাচ কি (Key) দিয়ে ম্যাচ খুঁজে বের করে।
     */
    private function findMatchByKey(string $match_key)
    {
        return FreefireMatch::where('Match_Key', $match_key)->first() 
               ?? LudoMatch::where('Match_Key', $match_key)->first()
               ?? PubgMatch::where('Match_Key', $match_key)->first();
    }

    /**
     * ম্যাচের তালিকা দেখানোর জন্য (Index Page)
     */
    public function index(string $game_type)
    {
        $model = $this->getModelInstance($game_type);
        
        $all_matches = $model->orderByRaw("FIELD(Position, 'OnGoing', 'Match', 'Result')")
                             ->orderBy('id', 'desc') 
                             ->get()
                             ->groupBy('Position');

        $titles = [
            'freefire' => 'FreeFire Matches', 
            'ludo'     => 'Ludo Matches', 
            'pubg'     => 'PUBG Matches'
        ];
        
        $icons = [
            'freefire' => 'fa-crosshairs', 
            'ludo'     => 'fa-dice', 
            'pubg'     => 'fa-gun'
        ];

        return view('admin.matches.index', [
            'all_matches' => $all_matches, 
            'game_type'   => $game_type,
            'page_title'  => $titles[$game_type] ?? 'Game Matches',
            'page_icon'   => $icons[$game_type] ?? 'fa-gamepad',
            'site_name'   => AdminSetting::first()->{'Splash Title'} ?? 'Admin Panel'
        ]);
    }

    /**
     * নতুন ম্যাচ তৈরির ফর্ম
     */
    public function create(string $game_type)
    {
        $titles = [
            'freefire' => 'Add FreeFire Match', 
            'ludo'     => 'Add Ludo Match', 
            'pubg'     => 'Add PUBG Match'
        ];

        return view('admin.matches.create', [
            'game_type'  => $game_type,
            'page_title' => $titles[$game_type] ?? 'Add Match',
            'page_icon'  => ($game_type == 'pubg') ? 'fa-gun' : (($game_type == 'freefire') ? 'fa-crosshairs' : 'fa-dice'),
            'site_name'  => AdminSetting::first()->{'Splash Title'} ?? 'Admin Panel'
        ]);
    }

    /**
     * নতুন ম্যাচ সেভ করা
     */
    public function store(Request $request, string $game_type)
    {
        $validated = $request->validate([
            'match_title'         => 'required|string|max:255',
            'match_time'          => 'required',
            'total_prize'         => 'required|numeric',
            'prize_1st'           => 'nullable|numeric',
            'prize_2nd'           => 'nullable|numeric',
            'prize_3rd'           => 'nullable|numeric',
            'per_kill'            => 'required|numeric',
            'entry_fee'           => 'required|numeric',
            'match_type'          => 'required|string',
            'entry_type_gameplay' => 'required|string',
            'version'             => 'required|string',
            'play_map'            => ($game_type == 'ludo') ? 'nullable|string' : 'required|string',
            'player_need'         => 'required|integer',
        ]);

        $model = $this->getModelInstance($game_type);
        $model->Match_Key    = 'match_' . uniqid();
        $model->Match_Title  = $validated['match_title'];
        $model->Match_Time   = $validated['match_time'];
        $model->Total_Prize  = $validated['total_prize'];
        $model->prize_1st    = $validated['prize_1st'] ?? '0';
        $model->prize_2nd    = $validated['prize_2nd'] ?? '0';
        $model->prize_3rd    = $validated['prize_3rd'] ?? '0';
        $model->Per_Kill     = $validated['per_kill'];
        $model->Entry_Fee    = $validated['entry_fee'];
        $model->Entry_Type   = $validated['entry_type_gameplay'];
        $model->Match_Type   = $validated['match_type'];
        $model->Version      = $validated['version'];
        $model->Play_Map     = ($game_type == 'ludo') ? 'Ludo' : $validated['play_map'];
        $model->Player_Need  = $validated['player_need'];
        $model->Player_Join  = 0;
        $model->Position     = 'Match';
        $model->save();

        try {
            $gameLabel = strtoupper($game_type);
            $title = "🔥 নতুন $gameLabel ম্যাচ যুক্ত হয়েছে!";
            $body  = "একটি নতুন ম্যাচ এড করা হয়েছে, এখনই জয়েন করুন! 🎮";
            $this->sendNotifications($title, $body);
        } catch (\Exception $e) {}

        return redirect()->route('admin.matches.index', $game_type)->with('success', 'Match created successfully!');
    }

    public function edit(string $game_type, $match_id)
    {
        $match = $this->findMatchById($game_type, $match_id);
        $site_name = AdminSetting::first()->{'Splash Title'} ?? 'Admin Panel';
        return view('admin.matches.edit', compact('match', 'game_type', 'site_name'));
    }

    public function update(Request $request, string $game_type, $match_id)
    {
        $match = $this->findMatchById($game_type, $match_id);
        
        $validated = $request->validate([
            'Match_Title' => 'required|string|max:255',
            'Match_Time'  => 'required',
            'Position'    => 'required|string|in:Match,OnGoing,Result',
            'Play_Map'    => 'nullable|string',
            'Version'     => 'nullable|string',
            'Entry_Type'  => 'nullable|string',
            'Total_Prize' => 'required|numeric',
            'Per_Kill'    => 'required|numeric',
            'Entry_Fee'   => 'required|numeric',
            'Player_Need' => 'required|integer',
            'Room_ID'     => 'nullable|string',
            'Room_Pass'   => 'nullable|string',
        ]);

        $match->update($validated);
        return redirect()->route('admin.matches.index', $game_type)->with('success', 'Match updated successfully!');
    }

    public function destroy(string $game_type, $match_id)
    {
        $match = $this->findMatchById($game_type, $match_id);
        try {
            DB::transaction(function () use ($match) {
                Joining::where('Match_Key', $match->Match_Key)->delete();
                Result::where('match_key', $match->Match_Key)->delete();
                $match->delete();
            });
            return redirect()->route('admin.matches.index', $game_type)->with('success', 'Match deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed: ' . $e->getMessage());
        }
    }

    public function showJoiners(string $game_type, string $match_key)
    {
        $match = $this->findMatchByKey($match_key);
        if (!$match) abort(404);
        $joiners = Joining::where('Match_Key', $match_key)->get();
        return view('admin.matches.joiners', compact('joiners', 'match', 'game_type'));
    }

    public function refundPlayer(Request $request, string $game_type, $join_id)
    {
        $joiner = Joining::findOrFail($join_id);
        $user = User::where('Number', $joiner->Number)->first();
        $entry_fee = (float)$request->input('entry_fee', 0);

        if ($user && $entry_fee > 0) {
            try {
                DB::transaction(function () use ($user, $entry_fee, $joiner, $game_type) {
                    $user->increment('Winning', $entry_fee); 
                    $this->getModelInstance($game_type)->where('Match_Key', $joiner->Match_Key)->decrement('Player_Join');
                    $joiner->delete();
                });
                return back()->with('success', "Player refunded successfully!");
            } catch (\Exception $e) {
                return back()->with('error', "Error: " . $e->getMessage());
            }
        }
        return back()->with('error', "User not found or fee invalid.");
    }

    public function showResultForm(string $game_type, string $match_key)
    {
        $match = $this->findMatchByKey($match_key);
        if (!$match) abort(404);
        $joiners = Joining::where('Match_Key', $match_key)->get();
        return view('admin.matches.result', compact('match', 'joiners', 'game_type'));
    }

    /**
     * রেজাল্ট প্রসেস করা - এখানে মূলত টাকা বিতরণের লজিক আপডেট হয়েছে।
     */
    public function processResult(Request $request, string $game_type, string $match_key)
    {
        $match = $this->findMatchByKey($match_key);
        if (!$match || $match->Position === 'Result') {
            return back()->with('error', 'Result already processed or match not found.');
        }

        try {
            DB::transaction(function () use ($request, $match, $match_key) {
                // ১. কিল প্রাইজ এবং টোটাল উইনিং আপডেট
                if ($request->has('kills')) {
                    foreach ($request->kills as $number => $killCount) {
                        if ($killCount > 0) {
                            $killPrize = $killCount * (float)$match->Per_Kill;
                            User::where('Number', $number)->increment('Winning', $killPrize);
                            Joining::where('Match_Key', $match_key)->where('Number', $number)
                                   ->update([
                                       'kills' => $killCount,
                                       'winnings' => DB::raw("winnings + $killPrize")
                                   ]);
                        }
                    }
                }

                // ২. উইনার পজিশন অনুযায়ী প্রাইজ বিতরণ (১ম, ২য়, ৩য়)
                $winners = [
                    1 => ['num' => $request->winner_1, 'prize' => (float)$match->prize_1st],
                    2 => ['num' => $request->winner_2, 'prize' => (float)$match->prize_2nd],
                    3 => ['num' => $request->winner_3, 'prize' => (float)$match->prize_3rd],
                ];

                foreach ($winners as $pos => $winner) {
                    if (!empty($winner['num']) && $winner['prize'] > 0) {
                        User::where('Number', $winner['num'])->increment('Winning', $winner['prize']);
                        Joining::where('Match_Key', $match_key)->where('Number', $winner['num'])
                               ->update([
                                   'winnings' => DB::raw("winnings + " . $winner['prize']), 
                                   'position' => $pos
                               ]);
                    }
                }

                // ৩. ম্যাচের স্ট্যাটাস 'Result' করে দেওয়া যেন দ্বিতীয়বার প্রসেস না হয়
                $match->Position = 'Result';
                $match->save();
            });

            return redirect()->route('admin.matches.index', $game_type)->with('success', 'Result processed and winnings distributed!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}