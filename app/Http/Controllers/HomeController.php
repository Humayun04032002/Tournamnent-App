<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSetting;
use App\Models\Notice;
use App\Models\Slider;
use App\Models\FreefireMatch;
use App\Models\LudoMatch;
use App\Models\PubgMatch;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // অ্যাডমিন সেটিংস (সাপোর্ট লিংক)
        $adminSettings = AdminSetting::find(1);
        $supportLink = $adminSettings ? $adminSettings->Support : '#';

        // নোটিশ
        $notice = Notice::find(1);
        $noticeText = $notice ? $notice->Notice : 'Welcome to OX FF TOUR!';

        // স্লাইডার
        $sliders = Slider::orderBy('id', 'desc')->get();

        // ম্যাচের সংখ্যা গণনা (Position 'Match' এবং 'OnGoing' উভয়ই কাউন্ট করা হচ্ছে)
        $gameCounts = [
            // --- Free Fire Counts ---
            'br_match'    => FreefireMatch::where('Match_Type', 'Classic')->where('Entry_Type', 'Solo')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            'clash_squad' => FreefireMatch::where('Match_Type', 'Clash Squad')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            'lone_wolf'   => FreefireMatch::where('Match_Type', 'LONE WOLF')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            'free_match'  => FreefireMatch::where('Match_Type', 'FREE MATCH')->whereIn('Position', ['Match', 'OnGoing'])->count(),

            // --- PUBG Counts (আপনার ডেটাবেস রেকর্ডের সাথে মিল রেখে) ---
            'pubg_solo'   => PubgMatch::where('Match_Type', 'Classic')->where('Entry_Type', 'Solo')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            'pubg_duo'    => PubgMatch::where('Match_Type', 'Classic')->where('Entry_Type', 'Duo')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            'pubg_squad'  => PubgMatch::where('Match_Type', 'Classic')->where('Entry_Type', 'Squad')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            'pubg_arena'  => PubgMatch::where('Match_Type', 'TDM 4VS4')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            
            // --- Others ---
            'ludo'        => LudoMatch::where('Match_Type', 'Ludo')->whereIn('Position', ['Match', 'OnGoing'])->count(),
            'cs_2v2'      => FreefireMatch::where('Match_Type', 'CS 2V2')->whereIn('Position', ['Match', 'OnGoing'])->count(),
        ];
        
        // ভিউতে ডেটা পাঠানো হচ্ছে
        return view('home', [
            'supportLink' => $supportLink,
            'noticeText'  => $noticeText,
            'sliders'     => $sliders,
            'gameCounts'  => $gameCounts,
        ]);
    }
}