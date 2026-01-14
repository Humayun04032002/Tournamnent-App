<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>My Matches - OX FF TOUR</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --accent: #ff007a;
            --bg-dark: #0a0b1e;
            --glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
            --success: #00ff88;
            --warning: #ffbd2e;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, #1a1b3a, #0a0b1e);
            color: #fff; margin: 0; padding-bottom: 100px;
        }

        .header {
            background: rgba(10, 11, 30, 0.8);
            backdrop-filter: blur(10px);
            text-align: center; padding: 18px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.1rem; color: var(--secondary);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 1000;
            letter-spacing: 2px;
        }
        
        .tabs-container {
            display: flex; justify-content: space-around;
            padding: 10px; background: rgba(255,255,255,0.02);
            border-bottom: 1px solid var(--border);
        }
        .tab-btn {
            background: none; border: none; color: #888;
            font-family: 'Orbitron'; font-size: 0.8rem;
            padding: 10px; cursor: pointer; transition: 0.3s;
        }
        .tab-btn.active { color: var(--secondary); border-bottom: 2px solid var(--secondary); }

        .match-list-container { padding: 15px; }
        
        .match-card { 
            background: var(--glass); border-radius: 20px; 
            margin-bottom: 20px; border: 1px solid var(--border);
            overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            position: relative;
        }

        .match-card.status-match { border-left: 5px solid var(--secondary); }
        .match-card.status-ongoing { border-left: 5px solid var(--accent); }
        .match-card.status-result { border-left: 5px solid var(--success); opacity: 0.9; }

        .status-bar { 
            display: flex; justify-content: space-between; align-items: center; 
            padding: 10px 15px; background: rgba(255,255,255,0.03); 
        }
        .status-badge { 
            font-size: 0.75rem; font-weight: bold; padding: 4px 12px; 
            border-radius: 6px; text-transform: uppercase; font-family: 'Orbitron';
        }
        .upcoming { background: rgba(0, 242, 254, 0.1); color: var(--secondary); }
        .live { background: rgba(255, 0, 122, 0.1); color: var(--accent); animation: pulse 1.5s infinite; }
        .completed { background: rgba(0, 255, 136, 0.1); color: var(--success); }
        
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.6; } 100% { opacity: 1; } }

        .countdown { font-size: 0.85rem; font-weight: bold; color: var(--warning); font-family: 'Orbitron'; }

        .match-body { padding: 20px; }
        .match-title { 
            font-family: 'Orbitron', sans-serif; font-weight: bold; 
            font-size: 0.95rem; margin: 0 0 12px 0; color: #fff; 
        }
        
        .info-row { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 5px; }
        .info-item { font-size: 0.85rem; color: #b0b0b0; display: flex; align-items: center; gap: 6px; }
        .info-item i { color: var(--primary); }

        .room-info-box {
            background: rgba(138, 43, 226, 0.1); border: 1px dashed var(--primary);
            border-radius: 12px; padding: 15px; margin-top: 15px;
            display: flex; justify-content: space-around; align-items: center;
        }
        .room-item { text-align: center; }
        .room-item small { display: block; color: #888; font-size: 0.65rem; text-transform: uppercase; margin-bottom: 4px; }
        .room-item span { font-weight: bold; color: var(--secondary); font-size: 1rem; font-family: 'Orbitron'; letter-spacing: 1px; }

        .copy-btn {
            background: var(--glass); border: 1px solid var(--border);
            color: var(--secondary); padding: 8px 12px; border-radius: 8px; cursor: pointer;
        }

        .result-section { 
            border-top: 1px solid var(--border); padding: 15px 20px; background: rgba(0, 255, 136, 0.03); 
        }
        .winner-line { font-weight: bold; font-size: 0.95rem; color: #eee; margin-bottom: 8px; }
        .winner-line span { color: var(--success); text-shadow: 0 0 10px rgba(0, 255, 136, 0.3); }
        .winner-calculating { color: var(--warning) !important; font-style: italic; animation: pulse 1s infinite; }
        
        .winnings-line { display: flex; justify-content: space-between; align-items: center; }
        .win-amt { font-weight: bold; color: var(--success); font-size: 1.1rem; }
        .loss-amt { font-weight: bold; color: #666; font-size: 1.1rem; }
        .rank-tag { font-size: 0.9rem; font-weight: bold; color: #aaa; }

        .txn-card {
            background: var(--glass); padding: 15px; border-radius: 15px;
            margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;
            border: 1px solid var(--border);
        }

        .no-match { 
            text-align: center; padding: 80px 20px; background: var(--glass); 
            border-radius: 20px; margin: 20px; border: 1px dashed var(--border);
        }

        #copyToast {
            visibility: hidden; min-width: 200px; background-color: var(--primary);
            color: #fff; text-align: center; border-radius: 10px; padding: 12px;
            position: fixed; z-index: 2000; left: 50%; bottom: 100px;
            transform: translateX(-50%); font-family: 'Orbitron'; font-size: 0.8rem;
        }
        #copyToast.show { visibility: visible; animation: fadeInOut 2s; }
        @keyframes fadeInOut { 0% { opacity: 0; } 20% { opacity: 1; } 80% { opacity: 1; } 100% { opacity: 0; } }
        #tempInput { position: absolute; left: -9999px; }
    </style>
</head>
<body>

    <div class="header">MY MATCHES</div>

    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('matches')">PLAYED MATCHES</button>
        <button class="tab-btn" onclick="switchTab('transactions')">TRANSACTIONS</button>
    </div>

    <input type="text" id="tempInput">
    <div id="copyToast">Room ID Copied!</div>

    <div id="matches-section" class="match-list-container">
        @php
            // Custom Sorting Logic:
            // 1. OnGoing (Live) Matches first
            // 2. Upcoming (Match) Matches next (sorted by time)
            // 3. Completed (Result) Matches last
            $sortedMatches = $playedMatches->sort(function($a, $b) {
                $order = ['OnGoing' => 1, 'Match' => 2, 'Result' => 3];
                $posA = $order[$a->Position] ?? 4;
                $posB = $order[$b->Position] ?? 4;

                if ($posA != $posB) {
                    return $posA <=> $posB;
                }
                
                // If same status, sort by time (Upcoming shows nearest first, Results show newest first)
                return $a->Position == 'Result' 
                    ? $b->Match_Time <=> $a->Match_Time 
                    : $a->Match_Time <=> $b->Match_Time;
            });
        @endphp

        @forelse ($sortedMatches as $match)
            @php
                try {
                    $matchTime = \Carbon\Carbon::parse($match->Match_Time);
                } catch (\Exception $e) {
                    $matchTime = \Carbon\Carbon::now();
                }
                $statusClass = strtolower($match->Position);
            @endphp

            <div class="match-card status-{{ $statusClass }}">
                <div class="status-bar">
                    @if($match->Position == 'OnGoing')
                        <span class="status-badge live"><i class="fas fa-circle"></i> LIVE</span>
                    @elseif($match->Position == 'Result')
                        <span class="status-badge completed"><i class="fas fa-check-circle"></i> COMPLETED</span>
                    @else
                        <span class="status-badge upcoming"><i class="fas fa-clock"></i> UPCOMING</span>
                    @endif

                    @if($match->Position == 'Match')
                        <div class="countdown" data-time="{{ $match->Match_Time }}">00:00:00</div>
                    @endif
                </div>

                <div class="match-body">
                    <p class="match-title">{{ $match->Match_Title }}</p>
                    
                    <div class="info-row">
                        <div class="info-item"><i class="fas fa-users"></i> {{ $match->Entry_Type }}</div>
                        <div class="info-item"><i class="far fa-calendar-alt"></i> {{ $matchTime->format('d M') }}</div>
                        <div class="info-item"><i class="far fa-clock"></i> {{ $matchTime->format('h:i A') }}</div>
                        <div class="info-item"><i class="fas fa-ticket-alt"></i> ৳{{ $match->Entry_Fee }}</div>
                    </div>

                    @if($match->Position != 'Result')
                        <div class="room-info-box">
                            @if(!empty($match->Room_ID) && !in_array(strtolower($match->Room_ID), ['none', '']))
                                <div class="room-item">
                                    <small>Room ID</small>
                                    <span>{{ $match->Room_ID }}</span>
                                </div>
                                <div style="width: 1px; height: 25px; background: var(--border);"></div>
                                <div class="room-item">
                                    <small>Password</small>
                                    <span>{{ $match->Room_Pass ?? 'N/A' }}</span>
                                </div>
                                <button class="copy-btn" onclick="copyToClipboard('{{ $match->Room_ID }}')">
                                    <i class="far fa-copy"></i>
                                </button>
                            @else
                                <div style="font-size: 0.85rem; color: var(--accent); font-style: italic; text-align: center; width: 100%;">
                                    <i class="fas fa-lock"></i> Room details will show 15 mins before match.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if($match->Position == 'Result')
                    <div class="result-section">
                        <div class="winner-line">
                            <i class="fas fa-crown" style="color: var(--warning);"></i> 
                            Winner: 
                            @if(!empty($match->winner_name) && strtolower($match->winner_name) != 'none')
                                <span>{{ $match->winner_name }}</span>
                            @else
                                <span class="winner-calculating">CALCULATING...</span>
                            @endif
                        </div>
                        <div class="winnings-line">
                            <span class="rank-tag">Position: #{{ $match->joining_position ?? 'N/A' }}</span>
                            @if($match->winnings > 0)
                                <span class="win-amt">+৳{{ $match->winnings }}</span>
                            @else
                                <span class="loss-amt">৳0</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="no-match">
                <i class="fas fa-gamepad" style="font-size: 3.5rem; margin-bottom: 15px; color: var(--primary); opacity: 0.5;"></i>
                <p style="color: #888;">You haven't joined any matches yet!</p>
                <a href="{{ route('home') }}" style="color: var(--secondary); text-decoration: none; font-weight: bold; margin-top: 10px; display: inline-block;">JOIN NOW</a>
            </div>
        @endforelse
    </div>

    <div id="transactions-section" class="match-list-container" style="display: none;">
        @forelse ($transactions as $txn)
            <div class="txn-card">
                <div>
                    <div style="font-weight: bold; color: #fff; font-size: 0.9rem; text-transform: uppercase;">{{ $txn->Method }}</div>
                    <small style="color: #888;">
                        @php $tDate = $txn->Date ?? $txn->time ?? now(); @endphp
                        {{ date('d M, h:i A', strtotime($tDate)) }}
                    </small>
                </div>
                <div style="font-family: 'Orbitron'; font-weight: bold; color: {{ $txn->type == 'Winning' ? 'var(--success)' : 'var(--accent)' }};">
                    {{ $txn->type == 'Winning' ? '+' : '-' }}৳{{ number_format($txn->Amount, 0) }}
                </div>
            </div>
        @empty
            <div class="no-match">
                <i class="fas fa-receipt" style="font-size: 3rem; margin-bottom: 15px; color: var(--primary); opacity: 0.4;"></i>
                <p style="color: #888;">No transaction history found.</p>
            </div>
        @endforelse
    </div>

    @include('partials.bottom-nav')

    <script>
        function switchTab(tab) {
            const mSec = document.getElementById('matches-section');
            const tSec = document.getElementById('transactions-section');
            const btns = document.querySelectorAll('.tab-btn');
            btns.forEach(b => b.classList.remove('active'));
            if(tab === 'matches') {
                mSec.style.display = 'block';
                tSec.style.display = 'none';
                btns[0].classList.add('active');
            } else {
                mSec.style.display = 'none';
                tSec.style.display = 'block';
                btns[1].classList.add('active');
            }
        }

        function initTimers() {
            document.querySelectorAll('.countdown').forEach(el => {
                const targetStr = el.getAttribute('data-time').replace(' ', 'T');
                const target = new Date(targetStr).getTime();
                const timer = setInterval(() => {
                    const now = new Date().getTime();
                    const diff = target - now;
                    if (diff <= 0) {
                        el.innerHTML = "STARTED";
                        clearInterval(timer);
                        return;
                    }
                    const h = Math.floor(diff / 3600000);
                    const m = Math.floor((diff % 3600000) / 60000);
                    const s = Math.floor((diff % 60000) / 1000);
                    el.innerHTML = `${h}h ${m}m ${s}s`;
                }, 1000);
            });
        }

        function copyToClipboard(text) {
            const input = document.getElementById('tempInput');
            const toast = document.getElementById('copyToast');
            input.value = text;
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            toast.className = "show";
            setTimeout(() => { toast.className = ""; }, 2000);
        }

        window.onload = initTimers;
    </script>
</body>
</html>