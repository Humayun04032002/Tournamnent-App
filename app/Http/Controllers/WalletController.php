<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\AdminSetting;
use App\Models\AddMoney;
use App\Models\Withdraw;
use App\Models\PendingPayment;

class WalletController extends Controller
{
    /**
     * ওয়ালেট ইনডেক্স পেজ।
     */
    public function index()
    {
        $user = Auth::user();
        $adminSettings = AdminSetting::first();

        // ডিপোজিট এবং উইথড্র হিস্টোরি একসাথে করা
        $deposits = DB::table('aerox_addmoney')
            ->select('Method', 'Amount', 'Date', 'Status', DB::raw("'Deposit' as type"))
            ->where('Number', $user->Number);

        $transactions = DB::table('aerox_withdraw')
            ->select('Method', 'Amount', 'Date', 'Status', DB::raw("'Withdraw' as type"))
            ->where('Number', $user->Number)
            ->unionAll($deposits)
            ->orderBy('Date', 'desc')
            ->limit(20)
            ->get();
            
        return view('wallet', [
            'user' => $user, 
            'adminSettings' => $adminSettings, 
            'transactions' => $transactions
        ]);
    }

    /**
     * ট্রানজেকশন হ্যান্ডেলার।
     */
    public function handleTransaction(Request $request)
    {
        $user = Auth::user();
        $adminSettings = AdminSetting::firstOrFail();
        $action = $request->input('action');
        $amount = abs((float)($request->input('amount') ?? 0));

        switch ($action) {
            case 'add_money':
                return $this->addMoney($request, $user, $adminSettings, $amount);
            case 'withdraw':
                return $this->withdraw($request, $user, $adminSettings, $amount);
            case 'transfer_balance':
                return $this->transferBalance($request, $user, $amount);
            default:
                return redirect()->route('wallet.index')
                    ->with('status_type', 'error')
                    ->with('status_message', 'Invalid Action!');
        }
    }

    /**
     * টাকা যোগ করার লজিক (Add Money)
     */
    private function addMoney(Request $request, User $user, AdminSetting $adminSettings, float $amount)
    {
        $trx_id = trim($request->input('transaction_id', ''));
        $method_from_user = $request->input('method');

        // ট্রানজেকশন আইডি ভ্যালিডেশন
        if (strlen($trx_id) < 5 || !ctype_alnum($trx_id)) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Transaction ID is invalid.');
        }

        if ($amount <= 0) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Please provide a valid amount.');
        }

        $paymentMode = $adminSettings->Payment_Mode ?? 'Manual';

        // Auto Mode চেক
        if ($paymentMode === 'Auto') {
            $pendingPayment = PendingPayment::where('trx_id', $trx_id)->first();
            if ($pendingPayment) {
                if (abs((float)$pendingPayment->amount - $amount) < 0.01) {
                    try {
                        DB::transaction(function () use ($user, $amount, $method_from_user, $trx_id, $pendingPayment) {
                            $user->increment('Balance', $amount);
                            
                            AddMoney::create([
                                'Name' => $user->Name, 
                                'Number' => $user->Number, 
                                'Method' => $method_from_user, 
                                'Amount' => $amount, 
                                'Payment' => $trx_id, 
                                'Date' => now(), 
                                'Status' => 'Complete'
                            ]);

                            $pendingPayment->delete();
                        });
                        return redirect()->route('wallet.index')->with('status_type', 'success')->with('status_message', 'Payment successful! Balance updated.');
                    } catch (\Exception $e) {
                        return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Database error. Please try later.');
                    }
                } else {
                    return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Amount mismatch for this Transaction ID.');
                }
            }
        }
        
        // Manual Mode বা Auto Verify ফেইল হলে পেন্ডিং রিকোয়েস্ট
        if (AddMoney::where('Payment', $trx_id)->exists()) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'This Transaction ID has already been used.');
        }

        AddMoney::create([
            'Name' => $user->Name, 
            'Number' => $user->Number, 
            'Method' => $method_from_user, 
            'Amount' => $amount, 
            'Payment' => $trx_id, 
            'Date' => now(), 
            'Status' => 'Pending'
        ]);

        $message = ($paymentMode === 'Auto') ? 'Auto-verify failed. Request sent for manual review.' : 'Add money request submitted successfully!';
        return redirect()->route('wallet.index')->with('status_type', 'success')->with('status_message', $message);
    }
    
    /**
     * টাকা উত্তোলনের লজিক (Withdraw)
     */
    private function withdraw(Request $request, User $user, AdminSetting $adminSettings, float $amount)
    {
        $current_winning = (float)$user->Winning;
        $min_withdraw = (float)($adminSettings->{'Minimum Withdraw'} ?? 100);
        $account_no = trim($request->input('account_no', ''));
        
        if ($amount <= 0 || $amount > $current_winning) {
             return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Insufficient winning balance.');
        }

        if ($amount < $min_withdraw) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', "Minimum withdraw limit is $min_withdraw BDT.");
        }

        if (empty($account_no)) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Please provide a valid account number.');
        }

        try {
            DB::transaction(function() use ($user, $amount, $request, $account_no) {
                $user->decrement('Winning', $amount);
                
                Withdraw::create([
                    'Name' => $user->Name, 
                    'Number' => $user->Number, 
                    'Method' => $request->input('method'),
                    'Amount' => $amount, 
                    'Payment' => $account_no, 
                    'Date' => now(), 
                    'Status' => 'Pending'
                ]);
            });
            return redirect()->route('wallet.index')->with('status_type', 'success')->with('status_message', 'Withdrawal request submitted!');
        } catch (\Exception $e) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Something went wrong. Please try again.');
        }
    }

    /**
     * উইনিং ব্যালেন্স থেকে মেইন ব্যালেন্সে ট্রান্সফার।
     */
    private function transferBalance(Request $request, User $user, float $amount)
    {
        $current_winning = (float)$user->Winning;

        if ($amount <= 0 || $amount > $current_winning) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Invalid amount or insufficient winning balance.');
        }
        
        try {
            DB::transaction(function () use ($user, $amount) {
                $user->decrement('Winning', $amount);
                $user->increment('Balance', $amount);
            });
            return redirect()->route('wallet.index')->with('status_type', 'success')->with('status_message', 'Balance transferred successfully!');
        } catch (\Exception $e) {
            return redirect()->route('wallet.index')->with('status_type', 'error')->with('status_message', 'Something went wrong during transfer.');
        }
    }
}