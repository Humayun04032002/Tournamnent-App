<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Process Result: {{ $match->Match_Title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6C5CE7; --secondary-color: #A29BFE; --bg-dark: #0F0F1A;
            --bg-light-dark: #1D1D30; --text-light: #F5F6FA; --text-secondary: #A29BFE;
            --border-color: rgba(255, 255, 255, 0.1); --success: #00B894; --danger: #D63031;
            --gold: #FFD700; --silver: #C0C0C0; --bronze: #CD7F32;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-light); min-height: 100vh; }
        
        .main-content { padding: 30px 20px; max-width: 800px; margin: auto; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 15px; }
        .header h1 { font-size: 22px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .header h1 i { color: var(--success); }
        
        .btn-back { text-decoration: none; color: var(--text-secondary); background-color: var(--bg-light-dark); border: 1px solid var(--border-color); padding: 8px 18px; border-radius: 8px; transition: all 0.3s; display: flex; align-items:center; gap: 8px; font-size: 14px; }
        .btn-back:hover { background-color: var(--primary-color); color: white; }

        .match-info-card { background: linear-gradient(135deg, var(--bg-light-dark), #252545); padding: 20px; border-radius: 15px; margin-bottom: 25px; border: 1px solid var(--border-color); display: flex; justify-content: space-around; text-align: center; }
        .info-item span { display: block; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; }
        .info-item strong { font-size: 18px; color: var(--primary-color); }

        .form-section { background-color: var(--bg-light-dark); border-radius: 15px; padding: 30px; border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        
        .form-group { margin-bottom: 25px; position: relative; }
        .form-group label { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; font-weight: 500; color: var(--text-light); }
        .form-group label i.rank-icon { font-size: 1.2rem; }
        .form-group label span.prize-tag { margin-left: auto; background: rgba(0, 184, 148, 0.15); color: var(--success); padding: 2px 10px; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid rgba(0, 184, 148, 0.3); }

        select { width: 100%; padding: 14px; background-color: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-light); font-size: 15px; outline: none; transition: all 0.3s; cursor: pointer; -webkit-appearance: none; }
        select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(108, 92, 231, 0.2); }
        select:disabled { opacity: 0.5; cursor: not-allowed; background-color: #05050a; }

        .btn-submit { width: 100%; padding: 16px; background: linear-gradient(135deg, var(--success), #00a383); border: none; border-radius: 12px; color: white; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; font-weight: 600; transition: all 0.3s; margin-top: 10px; }
        .btn-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 184, 148, 0.4); }
        .btn-submit:disabled { background: #333; color: #777; cursor: not-allowed; border: 1px solid var(--border-color); }

        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; font-size: 14px; }
        .alert-success { background: rgba(0, 184, 148, 0.15); color: #00e676; border: 1px solid rgba(0, 184, 148, 0.3); }
        .alert-error { background: rgba(214, 48, 49, 0.15); color: #ff7675; border: 1px solid rgba(214, 48, 49, 0.3); }

        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 20px; }
        .status-processed { background: rgba(0, 184, 148, 0.1); color: var(--success); border: 1px solid var(--success); }
        .status-pending { background: rgba(255, 152, 0, 0.1); color: #FF9800; border: 1px solid #FF9800; }

        @media (max-width: 600px) {
            .match-info-card { flex-direction: column; gap: 15px; }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <header class="header">
            <h1><i class="fas fa-trophy"></i> Process Match Result</h1>
            <a href="{{ route('admin.matches.index', $game_type) }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back</a>
        </header>

        <main>
            @if (session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</div>
            @endif

            <div class="match-info-card">
                <div class="info-item"><span>Game</span><strong>{{ ucfirst($game_type) }}</strong></div>
                <div class="info-item"><span>Match Title</span><strong>{{ $match->Match_Title }}</strong></div>
                <div class="info-item"><span>Entry Fee</span><strong>৳{{ $match->Entry_Fee }}</strong></div>
            </div>

            <div class="form-section">
                @if($match->Position == 'Result')
                    <div class="status-badge status-processed"><i class="fas fa-lock"></i> RESULT PROCESSED</div>
                @else
                    <div class="status-badge status-pending"><i class="fas fa-clock"></i> AWAITING RESULT</div>
                @endif

                <form action="{{ route('admin.matches.result.process', ['game_type' => $game_type, 'match_key' => $match->Match_Key]) }}" method="post">
                    @csrf
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-medal rank-icon" style="color: var(--gold);"></i> 1st Place Winner
                            <span class="prize-tag">Prize: ৳{{ $match->prize_1st }}</span>
                        </label>
                        <select name="winner_1" @if ($match->Position == 'Result' || $match->prize_1st <= 0) disabled @endif required>
                            <option value="">Choose 1st Winner</option>
                            @foreach ($joiners as $player)
                                <option value="{{ $player->Number }}">{{ $player->ingame_name }} (@ {{ $player->Name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-medal rank-icon" style="color: var(--silver);"></i> 2nd Place Winner
                            <span class="prize-tag">Prize: ৳{{ $match->prize_2nd }}</span>
                        </label>
                        <select name="winner_2" @if ($match->Position == 'Result' || $match->prize_2nd <= 0) disabled @endif>
                            <option value="">Choose 2nd Winner (Optional)</option>
                            @foreach ($joiners as $player)
                                <option value="{{ $player->Number }}">{{ $player->ingame_name }} (@ {{ $player->Name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-medal rank-icon" style="color: var(--bronze);"></i> 3rd Place Winner
                            <span class="prize-tag">Prize: ৳{{ $match->prize_3rd }}</span>
                        </label>
                        <select name="winner_3" @if ($match->Position == 'Result' || $match->prize_3rd <= 0) disabled @endif>
                            <option value="">Choose 3rd Winner (Optional)</option>
                            @foreach ($joiners as $player)
                                <option value="{{ $player->Number }}">{{ $player->ingame_name }} (@ {{ $player->Name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <p style="font-size: 11px; color: var(--text-secondary); margin-bottom: 15px; line-height: 1.4;">
                        <i class="fas fa-info-circle"></i> Submitting this form will automatically distribute prize money to the winners' wallets and move the match to the 'Completed' section.
                    </p>

                    <button type="submit" class="btn-submit" @if ($match->Position == 'Result') disabled @endif>
                        <i class="fas fa-paper-plane"></i> 
                        {{ ($match->Position == 'Result') ? 'Result Already Settled' : 'Confirm & Distribute Rewards' }}
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>