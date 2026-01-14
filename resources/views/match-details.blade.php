<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Match Details - {{ $match->Match_Title }}</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --accent: #ff007a;
            --bg-dark: #0a0b1e;
            --card-bg: rgba(255, 255, 255, 0.05);
            --glass: rgba(255, 255, 255, 0.08);
            --border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, #1a1b3a, #0a0b1e);
            color: #fff; margin: 0; padding-bottom: 220px;
        }

        /* --- Banner & Header --- */
        .banner-container { position: relative; width: 100%; height: 220px; overflow: hidden; }
        .banner { width: 100%; height: 100%; object-fit: cover; }
        .banner-overlay { position: absolute; inset: 0; background: linear-gradient(to top, var(--bg-dark), transparent); }

        .back-btn {
            position: absolute; top: 15px; left: 15px;
            width: 40px; height: 40px; background: rgba(0,0,0,0.5);
            border: 1px solid var(--border); border-radius: 50%;
            color: white; display: flex; align-items: center; justify-content: center;
            z-index: 10; text-decoration: none; backdrop-filter: blur(5px);
        }

        /* --- Title Section --- */
        .details-container { padding: 0 18px; margin-top: -30px; position: relative; z-index: 5; }
        
        .title-card {
            background: var(--glass); backdrop-filter: blur(15px);
            padding: 20px; border-radius: 20px; border: 1px solid var(--border);
            text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .title-card h1 { 
            font-family: 'Orbitron', sans-serif; font-size: 1.2rem; margin: 0; 
            color: var(--secondary); letter-spacing: 1px;
        }

        /* --- Neon Timer --- */
        .timer-box {
            margin: 20px 0; padding: 15px; background: rgba(0,0,0,0.3);
            border-radius: 15px; border: 1px solid var(--primary);
            text-align: center; font-family: 'Orbitron', sans-serif;
            box-shadow: inset 0 0 15px rgba(138, 43, 226, 0.2);
        }
        .timer-box span { color: var(--secondary); text-shadow: 0 0 10px var(--secondary); }

        /* --- Info Grid --- */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 20px; }
        .info-card {
            background: var(--glass); padding: 15px; border-radius: 15px;
            text-align: center; border: 1px solid var(--border);
        }
        .info-card i { font-size: 20px; color: var(--accent); margin-bottom: 8px; }
        .info-card h4 { margin: 0; font-size: 0.8rem; color: #b0b0b0; text-transform: uppercase; }
        .info-card p { margin: 4px 0 0; font-size: 1.1rem; font-weight: 700; color: #fff; }

        /* --- Joined Players Button --- */
        .btn-view {
            display: block; width: 100%; margin: 20px 0; padding: 12px;
            background: linear-gradient(45deg, #3a3a3a, #1a1a1a);
            color: var(--secondary); text-align: center; font-weight: 700;
            border-radius: 12px; text-decoration: none; border: 1px solid var(--border);
        }

        /* --- Rules Section --- */
        .rules-section {
            background: var(--glass); padding: 20px; border-radius: 18px;
            margin-top: 20px; border: 1px solid var(--border);
        }
        .rules-section h3 { 
            margin-top: 0; font-family: 'Orbitron', sans-serif; font-size: 0.9rem;
            color: var(--secondary); display: flex; align-items: center; gap: 10px;
        }
        .rules-section pre { 
            white-space: pre-wrap; font-family: 'Rajdhani'; line-height: 1.6; 
            color: #d0d0d0; font-size: 0.95rem; margin: 10px 0 0;
        }

        /* --- Join Footer (Floating Form) --- */
        .join-footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: #111420; padding: 20px;
            border-top: 2px solid var(--primary);
            border-radius: 25px 25px 0 0; z-index: 100;
            box-shadow: 0 -10px 40px rgba(0,0,0,0.8);
        }
        .join-form-group { margin-bottom: 12px; }
        .join-form-group label { display: block; margin-bottom: 6px; font-size: 0.85rem; color: var(--secondary); }
        .join-form-group input { 
            width: 100%; padding: 12px; background: rgba(255,255,255,0.05); 
            border: 1px solid var(--border); border-radius: 10px; color: #fff; font-family: 'Rajdhani';
        }
        .join-form-group input:focus { outline: none; border-color: var(--secondary); }

        .join-btn {
            width: 100%; padding: 15px; border: none; border-radius: 12px;
            background: var(--grad-pro); color: white;
            font-size: 1.1rem; font-weight: 700; font-family: 'Orbitron';
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.4); cursor: pointer;
        }
        .join-btn:disabled { background: #444; box-shadow: none; color: #888; }

        .error-msg { background: rgba(255, 0, 122, 0.1); color: var(--accent); padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center; font-weight: 600; font-size: 0.9rem; }

        /* --- Success Overlay --- */
        #success-animation-overlay {
            position: fixed; inset: 0; background: rgba(10, 11, 30, 0.95);
            z-index: 9999; display: none; flex-direction: column; align-items: center; justify-content: center;
        }
        #success-animation-overlay.visible { display: flex; }
    </style>
</head>
<body>

    <div class="banner-container">
        <a href="javascript:history.back()" class="back-btn"><i class="fas fa-arrow-left"></i></a>
        <img src="{{ asset($gameType === 'ludo' ? 'assets/images/04112025105845265_banner.jpeg' : 'assets/images/03112025175115927_banner.jpeg') }}" class="banner">
        <div class="banner-overlay"></div>
    </div>

    <div class="details-container">
        <div class="title-card">
            <h1>{{ $match->Match_Title }}</h1>
        </div>

        <div class="timer-box" id="match-timer" data-time="{{ $match->Match_Time }}">
            <i class="far fa-clock"></i> Loading Timer...
        </div>

        @if (session('error')) <p class="error-msg">{{ session('error') }}</p> @endif
        @if ($errors->any()) <p class="error-msg">{{ $errors->first() }}</p> @endif

        <div class="info-grid">
            <div class="info-card"><i class="fas fa-trophy"></i><h4>Total Prize</h4><p>৳{{ $match->Total_Prize }}</p></div>
            <div class="info-card"><i class="fas fa-skull"></i><h4>Per Kill</h4><p>৳{{ $match->Per_Kill }}</p></div>
            <div class="info-card"><i class="fas fa-users"></i><h4>Type</h4><p>{{ $match->Entry_Type }}</p></div>
            <div class="info-card"><i class="fas fa-map"></i><h4>Map</h4><p>{{ $match->Play_Map }}</p></div>
        </div>

        @php $joinersCount = \App\Models\Joining::where('Match_Key', $match->Match_Key)->count(); @endphp
        @if($joinersCount > 0)
            <a href="{{ route('user.matches.joiners', $match->id) }}" class="btn-view">
                <i class="fas fa-user-friends"></i> Joined Players ({{ $joinersCount }})
            </a>
        @endif   

        <div class="rules-section">
            <h3><i class="fas fa-file-contract"></i> RULES & REGULATIONS</h3>
            <pre>{{ $rulesText }}</pre>
        </div>
    </div>

    <div class="join-footer">
        @php
            $isFull = $match->Player_Join >= $match->Player_Need;
            $hasLowBalance = (float)$user->Balance < (float)$match->Entry_Fee;
            $buttonDisabled = $isJoined || $isFull || $hasLowBalance;
        @endphp

        @if (!$isJoined && $hasLowBalance)
            <p class="error-msg" style="margin-bottom: 10px;">Insufficient Balance! Please Recharge.</p>
        @endif

        <form id="joinForm" action="{{ route('match.join', ['id' => $match->id]) }}" method="post">
            @csrf
            <input type="hidden" name="game_type" value="{{ $gameType }}">
            <div id="player-inputs"></div>

            <button type="submit" class="join-btn" @if($buttonDisabled) disabled @endif>
                @if ($isJoined) ✓ ALREADY JOINED
                @elseif ($isFull) MATCH FULL
                @else JOIN NOW (৳{{ $match->Entry_Fee }})
                @endif
            </button>
        </form>
    </div>

    @if (session('success'))
        <div id="success-animation-overlay" class="visible">
            <lottie-player src="https://lottie.host/e2898144-6725-4070-a353-8395171732ad/qX2xms2T7w.json" background="transparent" speed="1" style="width: 250px; height: 250px;" autoplay></lottie-player>
            <h2 style="font-family: 'Orbitron'; color: var(--secondary);">{{ session('success') }}</h2>
            <p style="color: #b0b0b0;">Preparing your match entry...</p>
        </div>
    @endif

    <script>
        // Match Timer
        const timerElement = document.getElementById('match-timer');
        if(timerElement) {
            const matchTime = new Date(timerElement.getAttribute('data-time').replace(' ', 'T')).getTime();
            const countdown = setInterval(function() {
                const now = new Date().getTime();
                const distance = matchTime - now;
                if (distance < 0) {
                    clearInterval(countdown);
                    timerElement.innerHTML = "<span style='color: #ff4b4b;'>MATCH STARTED!</span>";
                    return;
                }
                const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((distance % (1000 * 60)) / 1000);
                timerElement.innerHTML = `STARTS IN: ${d > 0 ? '<span>' + d + '</span>d ' : ''}<span>${h}</span>h <span>${m}</span>m <span>${s}</span>s`;
            }, 1000);
        }

        // Dynamic Inputs
        const oldInputs = @json(session()->getOldInput());
        const matchType = "{{ $match->Entry_Type }}";
        const container = document.getElementById('player-inputs');
        let playersNeeded = (matchType === 'Duo') ? 2 : (matchType === 'Squad' ? 4 : 1);

        for (let i = 1; i <= playersNeeded; i++) {
            let labelText = (i === 1) ? "Your In-Game Name" : `Teammate ${i-1} Name`;
            let isRequired = (i === 1) ? 'required' : '';
            let val = oldInputs[`ingame_name_${i}`] || '';
            container.innerHTML += `
                <div class="join-form-group">
                    <label><i class="fas fa-user-edit"></i> ${labelText}</label>
                    <input type="text" name="ingame_name_${i}" ${isRequired} value="${val}" placeholder="Enter name...">
                </div>`;
        }

        @if (session('success'))
            setTimeout(() => { window.location.href = '{{ route("my.matches") }}'; }, 2500);
        @endif
    </script>
</body>
</html>