<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Leaderboard - OX FF TOUR</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --accent: #ff007a;
            --bg-dark: #0a0b1e;
            --glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
            --gold: #FFD700;
            --silver: #C0C0C0;
            --bronze: #CD7F32;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, #1a1b3a, #0a0b1e);
            color: #fff;
            margin: 0;
            padding: 18px;
            padding-bottom: 100px;
        }

        /* --- Header Styling --- */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 10px 0;
        }

        .back-btn {
            width: 40px; height: 40px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; cursor: pointer;
        }

        .header h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.2rem;
            margin: 0;
            color: var(--secondary);
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
        }

        /* --- Leaderboard Section --- */
        .leaderboard-section {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 20px 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .leaderboard-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            text-align: center;
            color: var(--accent);
            margin-bottom: 25px;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            text-transform: uppercase;
        }

        .leaderboard-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .player-row {
            display: flex;
            align-items: center;
            padding: 15px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
            border-radius: 12px;
            margin-bottom: 5px;
        }
        
        .player-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .rank {
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            font-weight: bold;
            width: 45px;
            text-align: center;
        }

        /* Rank Colors */
        .rank-1 { color: var(--gold); text-shadow: 0 0 10px rgba(255, 215, 0, 0.5); font-size: 1.4rem; }
        .rank-2 { color: var(--silver); text-shadow: 0 0 10px rgba(192, 192, 192, 0.5); font-size: 1.2rem; }
        .rank-3 { color: var(--bronze); text-shadow: 0 0 10px rgba(205, 127, 50, 0.5); font-size: 1.1rem; }
        .rank-normal { color: #888; }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid var(--border);
            padding: 2px;
            background: #151921;
        }

        .player-info {
            flex-grow: 1;
        }

        .player-info .name {
            font-weight: 700;
            font-size: 1rem;
            color: #e0e0e0;
            letter-spacing: 0.5px;
        }

        .player-score {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .no-data {
            text-align: center;
            color: var(--text-dim);
            padding: 40px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <button onclick="window.history.back()" class="back-btn">
            <i class="fas fa-chevron-left"></i>
        </button>
        <h1>TOP WINNERS</h1>
        <div style="width: 40px;"></div> </div>

    <div class="leaderboard-section">
        <h2 class="leaderboard-title">
            <i class="fas fa-crown"></i> HALL OF FAME
        </h2>
        
        <ul class="leaderboard-list">
            @forelse ($topWinners as $index => $player)
                <li class="player-row">
                    <div class="rank @if($index==0) rank-1 @elseif($index==1) rank-2 @elseif($index==2) rank-3 @else rank-normal @endif">
                        #{{ $index + 1 }}
                    </div>

                    <img src="{{ asset('assets/images/wired-flat-44-avatar-user-in-circle.gif') }}" alt="Avatar" class="avatar">
                    
                    <div class="player-info">
                        <span class="name">{{ $player->Name }}</span>
                    </div>
                    
                    <div class="player-score">
                        ৳{{ number_format($player->Winning, 0) }}
                    </div>
                </li>
            @empty
                <p class="no-data">No heroes on the board yet!</p>
            @endforelse
        </ul>
    </div>
    
    @include('partials.bottom-nav')

</body>
</html>