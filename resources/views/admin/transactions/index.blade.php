<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $page_title }} - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6C5CE7; 
            --secondary-color: #A29BFE; 
            --bg-dark: #0F0F1A;
            --bg-light-dark: #1D1D30; 
            --text-light: #F5F6FA; 
            --text-secondary: #A29BFE;
            --border-color: rgba(255, 255, 255, 0.1); 
            --success: #00B894; 
            --danger: #D63031;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body { 
            background-color: var(--bg-dark); 
            color: var(--text-light); 
            line-height: 1.6;
        }
        
        .main-content {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* --- Header --- */
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px;
            background: var(--bg-light-dark);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid var(--border-color);
        }
        
        .header h1 { font-size: 24px; font-weight: 600; display: flex; align-items: center; gap: 12px; }
        .header h1 i { color: var(--primary-color); }

        .btn-back { 
            text-decoration: none; 
            color: var(--text-light); 
            background-color: rgba(255,255,255,0.05); 
            border: 1px solid var(--border-color); 
            padding: 10px 20px; 
            border-radius: 10px; 
            transition: all 0.3s; 
            font-weight: 500;
        }
        .btn-back:hover { background-color: var(--primary-color); border-color: var(--primary-color); }
        
        /* --- Grid & Cards --- */
        .transactions-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
            gap: 20px; 
        }

        .transaction-card {
            background-color: var(--bg-light-dark); 
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 20px; 
            display: flex; 
            flex-direction: column; 
            gap: 15px;
            transition: transform 0.2s;
        }
        .transaction-card:hover { transform: translateY(-5px); }

        .card-header { display: flex; justify-content: space-between; align-items: flex-start; }
        .card-header h3 { margin: 0; font-size: 18px; color: var(--text-light); font-weight: 600; }
        .card-header .date { font-size: 12px; color: var(--text-secondary); opacity: 0.8; }

        .card-body { 
            background: rgba(0,0,0,0.2);
            padding: 15px; 
            border-radius: 12px;
            display: grid; 
            grid-template-columns: auto 1fr; 
            gap: 8px 15px; 
        }
        .card-body .label { font-size: 13px; font-weight: 500; color: var(--text-secondary); }
        .card-body .value { font-size: 14px; font-weight: 400; color: var(--text-light); }
        
        /* --- Transaction ID --- */
        .trx-id-wrapper { 
            background-color: var(--bg-dark); 
            padding: 12px; 
            border-radius: 8px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border: 1px dashed var(--border-color);
        }
        .trx-id { 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 14px; 
            color: var(--secondary-color); 
            font-weight: bold;
        }
        .copy-btn { background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 5px; }
        .copy-btn:hover { color: var(--primary-color); }

        /* --- Footer & Actions --- */
        .amount { 
            font-size: 26px; 
            font-weight: 700; 
            text-align: center; 
            margin: 10px 0;
            font-family: 'Poppins', sans-serif;
        }
        .amount.add-money { color: var(--success); }
        .amount.withdraw { color: var(--danger); }
        
        .actions { display: flex; gap: 12px; }
        .action-btn { 
            border: none; 
            padding: 12px; 
            border-radius: 10px; 
            cursor: pointer; 
            color: white; 
            font-weight: 600; 
            flex: 1; 
            font-size: 14px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px; 
            transition: all 0.3s; 
        }
        .btn-approve { background-color: var(--success); box-shadow: 0 4px 15px rgba(0, 184, 148, 0.2); }
        .btn-reject { background-color: var(--danger); box-shadow: 0 4px 15px rgba(214, 48, 49, 0.2); }
        .action-btn:hover { transform: scale(1.02); opacity: 0.9; }

        .no-data { 
            text-align: center; 
            color: var(--text-secondary); 
            padding: 60px; 
            background-color: var(--bg-light-dark); 
            border-radius: 20px; 
            grid-column: 1 / -1;
            border: 1px dashed var(--border-color);
        }

        @media (max-width: 480px) {
            .header { flex-direction: column; gap: 15px; text-align: center; }
            .transactions-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <header class="header">
            <h1><i class="fas {{ $page_icon }}"></i> {{ $page_title }}</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </header>

        <main>
            <div class="transactions-grid">
                @forelse ($transactions as $txn)
                    <div class="transaction-card">
                        <div class="card-header">
                            <h3>{{ $txn->Name }}</h3>
                            <span class="date">{{ \Carbon\Carbon::parse($txn->Date)->format('d M, Y') }}</span>
                        </div>
                        
                        <div class="card-body">
                            <span class="label">Number:</span> <span class="value">{{ $txn->Number }}</span>
                            <span class="label">Method:</span> <span class="value">{{ $txn->Method }}</span>
                            <span class="label">{{ $type === 'addmoney' ? 'From:' : 'To:' }}</span> 
                            <span class="value">{{ $txn->Payment }}</span>
                        </div>

                        @if ($type == 'addmoney' && !empty($txn->TrxID))
                            <div class="trx-id-wrapper">
                                <span class="trx-id" id="trx-{{ $txn->id }}">{{ $txn->TrxID }}</span>
                                <button class="copy-btn" onclick="copyTrxID('trx-{{ $txn->id }}', this)" title="Copy ID">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                        @endif

                        <div class="card-footer">
                            <div class="amount {{ $type == 'addmoney' ? 'add-money' : 'withdraw' }}">
                                ৳{{ number_format($txn->Amount, 2) }}
                            </div>
                            
                            <form action="{{ route('admin.transactions.update', ['type' => $type, 'id' => $txn->id]) }}" method="post" class="actions">
                                @csrf
                                <input type="hidden" name="user_number" value="{{ $txn->Number }}">
                                <input type="hidden" name="amount" value="{{ $txn->Amount }}">
                                
                                <button type="submit" name="action" value="approve" class="action-btn btn-approve" onclick="return confirm('APPROVE this request?');">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                
                                <button type="submit" name="action" value="reject" class="action-btn btn-reject" onclick="return confirm('REJECT this request?');">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <i class="fas fa-inbox fa-3x" style="margin-bottom: 15px; opacity: 0.3;"></i>
                        <p>All clear! No pending requests found.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <script>
        function copyTrxID(elementId, button) {
            const text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(() => {
                const icon = button.querySelector('i');
                icon.className = 'fas fa-check';
                icon.style.color = '#00B894';
                setTimeout(() => {
                    icon.className = 'far fa-copy';
                    icon.style.color = '';
                }, 2000);
            });
        }
    </script>
</body>
</html>