<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>My Wallet - OX FF TOUR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --bg-dark: #070916;
            --card-glass: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.08);
            --success: #00ffa3;
            --error: #ff3e3e;
            --bkash: #e2136e;
            --nagad: #f7941d;
            --rocket: #8c3494;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at 50% 0%, #1a1b3d 0%, #070916 70%);
            color: #fff; margin: 0; padding: 15px; 
            padding-bottom: 110px; /* নেভিগেশন বারের জন্য প্যাডিং বাড়ানো হয়েছে */
            overflow-x: hidden;
        }

        /* --- Balance Card --- */
        .balance-card {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            padding: 30px 20px; border-radius: 24px; text-align: center;
            margin-bottom: 25px; position: relative; overflow: hidden;
            box-shadow: 0 15px 35px rgba(106, 17, 203, 0.3);
            border: 1px solid rgba(255,255,255,0.15);
        }
        .balance-card::before {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        }
        .balance-card h4 { margin: 0; font-family: 'Orbitron'; font-size: 0.75rem; opacity: 0.7; letter-spacing: 2px; }
        .balance-card .amount { font-family: 'Orbitron'; font-size: 2.8rem; margin: 10px 0; font-weight: 800; text-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        .balance-card .sub-balance { 
            font-size: 1rem; background: rgba(0,0,0,0.25); display: inline-flex; align-items: center; 
            gap: 8px; padding: 6px 16px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.1);
        }

        /* --- Action Grid --- */
        .actions { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 30px; }
        .action-btn { 
            background: var(--card-glass); border: 1px solid var(--border); border-radius: 18px;
            padding: 18px 5px; text-align: center; color: #fff; cursor: pointer; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(10px);
        }
        .action-btn:active { transform: scale(0.92); background: rgba(255,255,255,0.1); }
        .action-btn i { font-size: 24px; margin-bottom: 10px; display: block; filter: drop-shadow(0 0 8px currentColor); }
        .action-btn span { font-size: 0.85rem; font-weight: 700; letter-spacing: 0.5px; }

        /* --- History Section --- */
        .history-section h3 { font-family: 'Orbitron'; font-size: 0.95rem; margin-bottom: 18px; color: var(--secondary); display: flex; align-items: center; gap: 10px; }
        .txn-item { 
            display: flex; justify-content: space-between; align-items: center; 
            background: var(--card-glass); padding: 16px; border-radius: 16px; margin-bottom: 12px;
            border: 1px solid var(--border); transition: 0.3s;
        }
        .txn-details p { margin: 0; font-weight: 700; font-size: 1rem; color: #eee; }
        .txn-details small { color: #777; font-size: 0.8rem; margin-top: 4px; display: block; }
        .txn-status-wrapper { text-align: right; }
        .txn-amount { font-family: 'Orbitron'; font-size: 0.95rem; font-weight: 800; }
        .txn-amount.deposit { color: var(--success); }
        .txn-amount.withdraw { color: var(--error); }

        /* --- Updated Status Styles --- */
        .txn-status { font-size: 0.65rem; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; margin-top: 6px; display: inline-block; font-weight: 800; letter-spacing: 0.5px; }
        
        /* Pending with Animation */
        .txn-status.pending { 
            background: rgba(255, 152, 0, 0.15); 
            color: #ff9800; 
            border: 1px solid #ff9800; 
            animation: pulse-pending 1.5s infinite ease-in-out;
        }
        
        /* Completed */
        .txn-status.completed { background: rgba(0, 255, 163, 0.15); color: var(--success); border: 1px solid var(--success); }
        
        /* Rejected */
        .txn-status.rejected { background: rgba(255, 62, 62, 0.15); color: var(--error); border: 1px solid var(--error); }

        /* Pulse Animation Keyframes */
        @keyframes pulse-pending {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* --- Modal System (FIXED FOR MOBILE) --- */
        .modal { 
            display: none; position: fixed; 
            z-index: 11000; /* নেভবার ৯৯৯৯ এর উপরে */
            left: 0; top: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.9); backdrop-filter: blur(15px); 
            justify-content: center; align-items: flex-end; 
        }
        .modal-content { 
            width: 100%; background: #0f1122; border-radius: 30px 30px 0 0; padding: 25px; 
            border-top: 2px solid var(--secondary); animation: slideUp 0.4s cubic-bezier(0, 0.55, 0.45, 1); 
            max-height: 88vh; /* ৮৮% হাইট যাতে টপ বার দেখা যায় */
            overflow-y: auto; box-sizing: border-box;
            padding-bottom: 50px; /* বাটনের নিচে জায়গা রাখার জন্য */
        }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
        
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h2 { margin: 0; font-size: 1.3rem; font-family: 'Orbitron'; color: #fff; text-transform: uppercase; }
        .close { width: 32px; height: 32px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }

        /* --- Method Selection --- */
        .method-container { display: flex; justify-content: space-between; gap: 10px; margin: 20px 0; }
        .method-card { 
            flex: 1; text-align: center; border: 2px solid var(--border); border-radius: 18px; padding: 10px; 
            cursor: pointer; background: rgba(255,255,255,0.02); transition: 0.3s;
        }
        .method-card img { width: 40px; height: 40px; object-fit: contain; border-radius: 8px; margin-bottom: 5px; }
        .method-card p { margin: 0; font-size: 0.8rem; font-weight: 800; color: #aaa; }
        .method-card.active { border-color: var(--secondary); background: rgba(0, 242, 254, 0.1); transform: translateY(-3px); }
        .method-card.active p { color: #fff; }

        /* --- Payment Box --- */
        .payment-box { 
            background: var(--bkash); padding: 20px; border-radius: 20px; margin-top: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .payment-box h3 { text-align: center; font-size: 1rem; margin-top: 0; font-family: 'Orbitron'; margin-bottom: 15px; }
        .payment-box .steps p { font-size: 0.85rem; line-height: 1.5; margin-bottom: 8px; opacity: 0.9; }
        
        .copy-box { 
            background: rgba(0,0,0,0.3); border-radius: 12px; padding: 10px 15px; 
            display: flex; align-items: center; justify-content: space-between; margin: 12px 0;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .copy-box span { font-family: 'Orbitron'; font-weight: 800; font-size: 1.1rem; letter-spacing: 1px; }
        .copy-btn { background: #fff; color: #000; border: none; padding: 5px 12px; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 0.7rem; }

        /* --- Forms --- */
        .form-group { margin-top: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 700; font-size: 0.85rem; color: rgba(255,255,255,0.8); }
        .form-group input, .form-group select { 
            width: 100%; padding: 14px; background: rgba(0,0,0,0.4); border: 1px solid var(--border); 
            border-radius: 12px; color: #fff; font-size: 1rem; box-sizing: border-box; outline: none;
        }

        .verify-btn { 
            width: 100%; padding: 16px; border: none; border-radius: 16px; background: #fff; color: var(--bkash); 
            font-size: 1.1rem; font-weight: 800; cursor: pointer; margin-top: 20px; 
            margin-bottom: 10px; /* নিচের স্পেস */
            font-family: 'Orbitron'; text-transform: uppercase; transition: 0.3s;
        }
        .verify-btn:active { transform: scale(0.96); }

        .info-msg { 
            background: rgba(255, 189, 46, 0.1); border-left: 4px solid #ffbd2e;
            padding: 12px; border-radius: 10px; font-size: 0.8rem; color: #ffbd2e; 
            margin-top: 15px; font-weight: 500;
        }

        /* আইফোন সেফ এরিয়া */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            .modal-content {
                padding-bottom: calc(60px + env(safe-area-inset-bottom));
            }
        }

    </style>
</head>
<body>

    <div class="balance-card">
        <h4>WALLET BALANCE</h4>
        <h1 class="amount">৳{{ number_format($user->Balance ?? 0, 2) }}</h1>
        <div class="sub-balance">
            <i class="fas fa-trophy" style="color: #ffbd2e;"></i> 
            <span>Winning: ৳{{ number_format($user->Winning ?? 0, 2) }}</span>
        </div>
    </div>

    <div class="actions">
        <button class="action-btn" onclick="openModal('addMoneyModal')">
            <i class="fas fa-wallet" style="color:var(--success)"></i> 
            <span>ADD MONEY</span>
        </button>
        <button class="action-btn" onclick="openModal('withdrawModal')">
            <i class="fas fa-hand-holding-usd" style="color:var(--error)"></i> 
            <span>WITHDRAW</span>
        </button>
        <button class="action-btn" onclick="openModal('transferModal')">
            <i class="fas fa-sync-alt" style="color:var(--secondary)"></i> 
            <span>TRANSFER</span>
        </button>
    </div>

    <div class="history-section">
        <h3><i class="fas fa-bolt"></i> RECENT ACTIVITY</h3>
        @forelse ($transactions as $txn)
            <div class="txn-item">
                <div class="txn-details">
                    <p>{{ $txn->type }}</p>
                    <small>{{ $txn->Method }} • {{ \Carbon\Carbon::parse($txn->Date)->format('d M, h:i A') }}</small>
                </div>
                <div class="txn-status-wrapper">
                    <div class="txn-amount {{ strtolower($txn->type) }}">
                        {{ $txn->type == 'Deposit' ? '+' : '-' }}৳{{ number_format((float)$txn->Amount, 2) }}
                    </div>
                    <div class="txn-status {{ strtolower($txn->Status) }}">
                        {{ $txn->Status }}
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding: 40px 20px; opacity: 0.4;">
                <i class="fas fa-folder-open" style="font-size: 40px; margin-bottom: 10px;"></i>
                <p>No transactions yet</p>
            </div>
        @endforelse
    </div>

    <div id="addMoneyModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Money</h2>
                <div class="close" onclick="closeModal('addMoneyModal')"><i class="fas fa-times"></i></div>
            </div>

            <form method="POST" action="{{ route('wallet.transaction') }}">
                @csrf
                <input type="hidden" name="action" value="add_money">
                <input type="hidden" id="add_method" name="method" value="bKash">

                <div class="method-container">
                    <div class="method-card active" onclick="selectMethod('bKash', event)">
                        <img src="{{ asset('assets/images/b.png') }}" alt="bKash">
                        <p>bKash</p>
                    </div>
                    <div class="method-card" onclick="selectMethod('Rocket', event)">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/45/Rocket_mobile_banking_logo.svg" alt="Rocket">
                        <p>Rocket</p>
                    </div>
                    <div class="method-card" onclick="selectMethod('Nagad', event)">
                        <img src="{{ asset('assets/images/Nagad_Logo.svg') }}" alt="Nagad">
                        <p>Nagad</p>
                    </div>
                </div>

                <div class="payment-box" id="paymentBoxStyle">
                    <h3>SEND MONEY STEPS</h3>
                    <div class="steps" id="paymentSteps"></div>

                    <div class="form-group">
                        <label>Amount (৳)</label>
                        <input type="number" name="amount" placeholder="যেমনঃ ৫০০" required>
                    </div>

                    <div class="form-group">
                        <label>Transaction ID</label>
                        <input type="text" name="transaction_id" placeholder="8N6X..." required>
                    </div>

                    <button type="submit" class="verify-btn" id="dynamicVerifyBtn">VERIFY NOW</button>
                </div>
            </form>
        </div>
    </div>

    <div id="withdrawModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Withdraw</h2>
                <div class="close" onclick="closeModal('withdrawModal')"><i class="fas fa-times"></i></div>
            </div>
            <form method="POST" action="{{ route('wallet.transaction') }}">
                @csrf
                <input type="hidden" name="action" value="withdraw">
                <div class="form-group">
                    <label>Select Method</label>
                    <select name="method">
                        <option value="bKash">bKash</option>
                        <option value="Nagad">Nagad</option>
                        <option value="Rocket">Rocket</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Amount (৳)</label>
                    <input type="number" step="0.01" name="amount" placeholder="Min ৳{{ number_format((float)($adminSettings->{'Minimum Withdraw'} ?? 0), 2) }}" required>
                </div>
                <div class="form-group">
                    <label>Receiver Number</label>
                    <input type="text" name="account_no" placeholder="017XXXXXXXX" required>
                </div>
                <div class="info-msg">
                    <i class="fas fa-exclamation-triangle"></i> উইনিং ব্যালেন্স থেকে উইথড্র করা যাবে। প্রতিটি উইথড্রতে ৫ টাকা চার্জ প্রযোজ্য।
                </div>
                <button type="submit" class="verify-btn" style="background:var(--error); color:#fff;">SUBMIT WITHDRAW</button>
            </form>
        </div>
    </div>

    <div id="transferModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Transfer</h2>
                <div class="close" onclick="closeModal('transferModal')"><i class="fas fa-times"></i></div>
            </div>
            <form method="POST" action="{{ route('wallet.transaction') }}">
                @csrf
                <input type="hidden" name="action" value="transfer_balance">
                <p style="text-align:center; color: var(--secondary); font-family: 'Orbitron'; font-size: 1.2rem;">WINNING: ৳{{ number_format($user->Winning ?? 0, 2) }}</p>
                <div class="form-group">
                    <label>Transfer Amount</label>
                    <input type="number" step="0.01" name="amount" placeholder="0.00" required max="{{ (float)($user->Winning ?? 0) }}">
                </div>
                <div class="info-msg">উইনিং ব্যালেন্স মেইন ব্যালেন্সে ট্রান্সফার করলে তা দিয়ে ম্যাচ খেলতে পারবেন।</div>
                <button type="submit" class="verify-btn" style="background:var(--secondary); color:#000;">CONFIRM TRANSFER</button>
            </form>
        </div>
    </div>

    @include('partials.bottom-nav')

    <script>
        const paymentData = {
            bKash: { number: "{{ $adminSettings->{'bKash Number'} ?? '01339201003' }}", dial: '*247#', app: 'bKash', color: '#e2136e', textColor: '#fff' },
            Rocket: { number: "{{ $adminSettings->{'Rocket Number'} ?? '01700000000' }}", dial: '*322#', app: 'Rocket', color: '#8c3494', textColor: '#fff' },
            Nagad: { number: "{{ $adminSettings->{'Nagad Number'} ?? '01800000000' }}", dial: '*167#', app: 'Nagad', color: '#f7941d', textColor: '#fff' }
        };

        function openModal(id) { 
            document.getElementById(id).style.display = 'flex';
            document.body.style.overflow = 'hidden'; 
        }
        
        function closeModal(id) { 
            document.getElementById(id).style.display = 'none';
            document.body.style.overflow = 'auto'; 
        }

        function selectMethod(method, event) {
            document.getElementById('add_method').value = method;
            document.querySelectorAll('.method-card').forEach(card => card.classList.remove('active'));
            event.currentTarget.classList.add('active');
            updatePaymentSteps(method);
        }

        function updatePaymentSteps(method) {
            const data = paymentData[method];
            const stepsContainer = document.getElementById('paymentSteps');
            const paymentBox = document.getElementById('paymentBoxStyle');
            const verifyBtn = document.getElementById('dynamicVerifyBtn');

            paymentBox.style.background = data.color;
            paymentBox.style.color = data.textColor;
            verifyBtn.style.color = data.color;

            stepsContainer.innerHTML = `
                <p>🔘 ${data.dial} ডায়াল করে অথবা <strong>${data.app}</strong> অ্যাপ ব্যবহার করুন।</p>
                <p>🔘 <strong>Send Money</strong> অপশনটি সিলেক্ট করুন।</p>
                <div class="copy-box">
                    <span id="pNum">${data.number}</span>
                    <button type="button" class="copy-btn" onclick="copyNum()">Copy</button>
                </div>
                <p>🔘 সফল হওয়ার পর <strong>Transaction ID</strong> ও <strong>Amount</strong> নিচের বক্সে দিন।</p>
            `;
        }

        function copyNum() {
            const num = document.getElementById('pNum').innerText;
            navigator.clipboard.writeText(num);
            alert('Number Copied: ' + num);
        }

        window.onclick = function(event) { 
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => { updatePaymentSteps('bKash'); });
    </script>
</body>
</html>