<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>{{ $pageTitle }} - OX FF TOUR</title>
    
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
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, #1a1b3a, #0a0b1e);
            color: #fff; margin: 0; padding: 15px;
            padding-bottom: 80px;
        }

        /* --- Header Styling --- */
        .header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 25px; padding: 5px 0;
        }
        .back-btn {
            width: 40px; height: 40px; background: var(--glass);
            border: 1px solid var(--border); border-radius: 12px;
            color: #fff; display: flex; align-items: center; justify-content: center;
            text-decoration: none; font-size: 18px;
        }
        .header h1 {
            font-family: 'Orbitron', sans-serif; font-size: 1.1rem;
            margin: 0; color: var(--secondary); letter-spacing: 1px;
        }

        /* --- Match Card Styling --- */
        .match-card {
            background: var(--glass); backdrop-filter: blur(10px);
            border-radius: 20px; margin-bottom: 25px;
            border: 1px solid var(--border); position: relative;
            overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            transition: transform 0.3s;
        }
        .match-card.joined-card { border: 1.5px solid var(--primary); }

        .match-card-header {
            display: flex; align-items: center; padding: 15px;
            background: rgba(255,255,255,0.02);
        }
        .match-card-header img {
            width: 55px; height: 55px; border-radius: 12px;
            margin-right: 15px; border: 2px solid var(--border);
        }
        .header-info h3 {
            margin: 0; font-family: 'Orbitron', sans-serif;
            font-size: 0.95rem; color: #fff;
        }
        .header-info p { margin: 4px 0 0; font-size: 0.85rem; color: #b0b0b0; }
        
        .match-id {
            position: absolute; top: 0; right: 0;
            background: var(--primary); color: white;
            padding: 4px 12px; font-size: 0.75rem; font-weight: bold;
            border-bottom-left-radius: 12px; font-family: 'Orbitron';
        }

        /* Room ID Box */
        .room-access-box {
            background: rgba(0, 255, 136, 0.1); margin: 0 15px 15px;
            padding: 12px; border-radius: 12px;
            border: 1px dashed var(--success); text-align: center;
        }
        .room-access-box p { margin: 3px 0; color: var(--success); font-weight: 700; font-size: 0.9rem; letter-spacing: 1px; }

        /* Stats Grid */
        .match-card-body {
            padding: 15px; display: grid; grid-template-columns: 1fr 1fr 1fr;
            gap: 12px; text-align: center;
        }
        .stat-block p { font-size: 0.65rem; color: #888; margin: 0 0 3px 0; text-transform: uppercase; }
        .stat-block h4 { margin: 0; font-size: 1rem; color: #fff; font-weight: 700; }

        /* Progress Bar */
        .match-card-progress { padding: 5px 15px 15px; }
        .progress-bar { width: 100%; background: #1a1b3a; border-radius: 10px; height: 8px; overflow: hidden; }
        .progress-bar-fill {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            height: 100%; border-radius: 10px; transition: 1s ease;
        }
        .progress-info {
            display: flex; justify-content: space-between;
            font-size: 0.8rem; color: #b0b0b0; margin-top: 8px;
        }
        .joined-status {
            color: var(--success); font-weight: bold; display: flex; align-items: center; gap: 5px;
        }

        /* Actions */
        .match-card-actions {
            padding: 12px 15px; background: rgba(0,0,0,0.2);
            display: flex; gap: 10px;
        }
        .action-btn {
            flex: 1; padding: 10px; border-radius: 10px;
            text-decoration: none; text-align: center; font-weight: 700;
            font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 6px;
            transition: 0.3s;
        }
        .btn-join { background: var(--primary); color: white; border: none; }
        .btn-prize { background: var(--glass); color: #fff; border: 1px solid var(--border); }

        /* Footer / Timer */
        .match-card-footer {
            background: rgba(138, 43, 226, 0.1); color: var(--secondary);
            text-align: center; padding: 12px; font-weight: 700;
            border-top: 1px solid var(--border); font-family: 'Orbitron';
            font-size: 0.85rem;
        }

        /* Modal Styling */
        .modal {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.8); backdrop-filter: blur(8px);
            z-index: 1000; align-items: center; justify-content: center; padding: 20px;
        }
        .modal-content {
            background: #111420; border: 1px solid var(--primary);
            padding: 25px; border-radius: 20px; width: 100%; max-width: 350px;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h2 { font-family: 'Orbitron'; font-size: 1rem; margin: 0; color: var(--secondary); }
        .close-btn { color: #fff; font-size: 24px; cursor: pointer; }
        .prize-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border); }

        .no-match { text-align: center; padding: 100px 20px; color: #555; }
    </style>
</head>
<body>

    <div class="header">
        <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-chevron-left"></i></a>
        <h1>{{ $pageTitle }}</h1>
        <div style="width: 40px;"></div>
    </div>

    @forelse ($matches as $match)
        @php
            $progress = ($match->Player_Need > 0) ? ($match->Player_Join / $match->Player_Need) * 100 : 0;
            $isUserJoined = in_array($match->Match_Key, $joinedMatchKeys);
            
            // Image Logic
            $imagePath = 'assets/images/IMG_20251113_175156_516.jpeg';
            if($type === 'ludo') $imagePath = 'assets/images/ludo.jpeg';
            if(strpos($type, 'pubg') !== false) $imagePath = 'assets/images/pubg_icon.png';
        @endphp

        <div class="match-card {{ $isUserJoined ? 'joined-card' : '' }}">
            <div class="match-id">#{{ $match->id }}</div>
            
            <div class="match-card-header">
                <img src="{{ asset($imagePath) }}" alt="Game Icon">
                <div class="header-info">
                    <h3>{{ $match->Match_Title }}</h3>
                    <p><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($match->Match_Time)->format('d M, h:i A') }}</p>
                </div>
            </div>

            @if($isUserJoined && $match->Position === 'OnGoing' && $match->Room_ID)
                <div class="room-access-box">
                    <p><i class="fas fa-fingerprint"></i> ID: {{ $match->Room_ID }}</p>
                    <p><i class="fas fa-key"></i> PASS: {{ $match->Room_Pass }}</p>
                </div>
            @endif

            <div class="match-card-body">
                <div class="stat-block"><p>WIN PRIZE</p><h4>৳{{ $match->Total_Prize }}</h4></div>
                <div class="stat-block"><p>PER KILL</p><h4>৳{{ $match->Per_Kill }}</h4></div>
                <div class="stat-block"><p>ENTRY FEE</p><h4>৳{{ $match->Entry_Fee }}</h4></div>
                <div class="stat-block"><p>TYPE</p><h4>{{ $match->Entry_Type }}</h4></div>
                <div class="stat-block"><p>MAP</p><h4>{{ $match->Play_Map }}</h4></div>
                <div class="stat-block"><p>VERSION</p><h4>{{ $match->Version }}</h4></div>
            </div>

            <div class="match-card-progress">
                <div class="progress-bar"><div class="progress-bar-fill" style="width: {{ $progress }}%;"></div></div>
                <div class="progress-info">
                    <span>{{ max(0, $match->Player_Need - $match->Player_Join) }} Seats Left</span>
                    @if($isUserJoined)
                        <span class="joined-status"><i class="fas fa-check-circle"></i> JOINED</span>
                    @else
                        <span style="color: #fff;">{{ $match->Player_Join }}/{{ $match->Player_Need }}</span>
                    @endif
                </div>
            </div>

            <div class="match-card-actions">
                @if(!$isUserJoined)
                    <a href="{{ route('match.details', ['game' => $type, 'id' => $match->id]) }}" class="action-btn btn-join">
                        <i class="fas fa-bolt"></i> JOIN NOW
                    </a>
                @else
                    <button class="action-btn" style="background: rgba(0, 255, 136, 0.1); color: var(--success); border: 1px solid var(--success); cursor: default;">
                         JOINED
                    </button>
                @endif

                <button class="action-btn btn-prize" onclick="showPrizeDetails('{{ $match->Total_Prize }}', '{{ $match->prize_1st ?? '0' }}', '{{ $match->prize_2nd ?? '0' }}', '{{ $match->prize_3rd ?? '0' }}')">
                    <i class="fas fa-gift"></i> PRIZES
                </button>
            </div>

            <a href="{{ route('user.matches.joiners', $match->id) }}" style="text-decoration: none;">
                <div class="match-card-footer" data-time="{{ $match->Match_Time }}">
                    <span class="countdown">LOADING...</span>
                </div>
            </a>
        </div>
    @empty
        <div class="no-match">
            <lottie-player src="https://lottie.host/936a1668-3563-487c-8646-d24329d007c9/H4X178K1zG.json" background="transparent" speed="1" style="width: 200px; height: 200px; margin: auto;" loop autoplay></lottie-player>
            <p>No matches available right now.</p>
        </div>
    @endforelse

    <div id="prizeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>PRIZE POOL</h2>
                <span class="close-btn" onclick="closeModal('prizeModal')">&times;</span>
            </div>
            <div id="prizeList"></div>
        </div>
    </div>

    <script>
        // Countdown Timer
        function updateCountdowns() {
            document.querySelectorAll('.match-card-footer').forEach(footer => {
                const countdownElement = footer.querySelector('.countdown');
                const matchTime = new Date(footer.getAttribute('data-time').replace(' ', 'T')).getTime();
                const now = new Date().getTime();
                const distance = matchTime - now;

                if (distance < 0) {
                    countdownElement.innerHTML = "MATCH STARTED";
                    countdownElement.style.color = "#ff4b4b";
                } else {
                    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((distance % (1000 * 60)) / 1000);
                    countdownElement.innerHTML = `STARTS IN: ${h}h ${m}m ${s}s`;
                }
            });
        }
        setInterval(updateCountdowns, 1000);

        function closeModal(id) { document.getElementById(id).style.display = "none"; }
        
        function showPrizeDetails(total, p1, p2, p3) {
            let html = `<div class="prize-item"><span>Total Pool</span><span style="color:var(--secondary)">৳${total}</span></div>`;
            if(parseFloat(p1) > 0) html += `<div class="prize-item"><span>1st Place</span><span>৳${p1}</span></div>`;
            if(parseFloat(p2) > 0) html += `<div class="prize-item"><span>2nd Place</span><span>৳${p2}</span></div>`;
            if(parseFloat(p3) > 0) html += `<div class="prize-item"><span>3rd Place</span><span>৳${p3}</span></div>`;
            
            document.getElementById('prizeList').innerHTML = html;
            document.getElementById('prizeModal').style.display = "flex";
        }
    </script>
</body>
</html>
