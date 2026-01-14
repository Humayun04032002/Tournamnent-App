<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AddMoney;
use App\Models\Withdraw;
use App\Models\AdminSetting; // আপনার SQL অনুযায়ী এটি aerox_admin টেবিল হতে পারে
use App\Models\FreefireMatch; // আপনার SQL অনুযায়ী এটি aerox_freefire টেবিল
// PubgMatch এবং LudoMatch আপনার SQL ফাইলে টেবিল হিসেবে নেই, তাই এগুলো বাদ দেওয়া হয়েছে অথবা আপনি নিজের প্রয়োজন মতো যোগ করতে পারেন।
use App\Models\LudoMatch; 
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * অ্যাডমিন ড্যাশবোর্ড প্রদর্শন এবং পরিসংখ্যান সংগ্রহ।
     */
    public function index()
    {
        // আজকের তারিখের শুরু এবং শেষ সময়
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();

        // ড্যাশবোর্ডের জন্য বিস্তারিত ডেটা সংগ্রহ
        $dashboardData = [
            // ইউজার পরিসংখ্যান - আপনার SQL অনুযায়ী কলামের নাম 'Register'
            'total_users' => User::count(),
            'new_users_today' => User::whereBetween('Register', [$todayStart, $todayEnd])->count(),

            // পেমেন্ট রিকোয়েস্ট (পেন্ডিং)
            'pending_addmoney' => AddMoney::where('Status', 'Pending')->count(),
            'pending_withdraw' => Withdraw::where('Status', 'Pending')->count(),

            // আর্থিক পরিসংখ্যান (আজকের) - আপনার SQL অনুযায়ী কলামের নাম 'Date'
            'today_deposits' => AddMoney::where('Status', 'Complete')
                                        ->whereBetween('Date', [$todayStart, $todayEnd])
                                        ->sum('Amount'),
            
            'today_withdrawals' => Withdraw::where('Status', 'Complete')
                                           ->whereBetween('Date', [$todayStart, $todayEnd])
                                           ->sum('Amount'),

            // মোট ব্যালেন্স - আপনার SQL অনুযায়ী কলামের নাম 'Balance' এবং 'Winning'
            'total_user_balance' => User::sum('Balance') + User::sum('Winning'),

            // গেম ম্যাচ পরিসংখ্যান (FreeFire টেবিল থেকে)
            'active_matches' => FreefireMatch::whereIn('Position', ['Match', 'OnGoing'])->count(),

            // সাইট সেটিংস - আপনার SQL অনুযায়ী 'Splash Title' কলাম
            'site_name' => AdminSetting::first()->{'Splash Title'} ?? 'Admin Panel',
        ];

        return view('admin.dashboard', $dashboardData);
    }
}