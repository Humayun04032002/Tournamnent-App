<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title }} - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6C5CE7; --secondary-color: #A29BFE; --bg-dark: #0F0F1A;
            --bg-light-dark: #1D1D30; --text-light: #F5F6FA; --text-secondary: #A29BFE;
            --border-color: rgba(255, 255, 255, 0.1); --success: #00B894; --danger: #D63031;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-light); }
        .main-content { margin: auto; max-width: 900px; width: 100%; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { font-size: 28px; font-weight: 600; }
        .btn-back { text-decoration: none; color: var(--text-secondary); background-color: var(--bg-light-dark); border: 1px solid var(--border-color); padding: 8px 15px; border-radius: 8px; display: flex; align-items: center; gap: 8px; transition: all 0.3s; }
        .btn-back:hover { background-color: var(--primary-color); color: white; }
        .form-section { background-color: var(--bg-light-dark); border-radius: 10px; padding: 25px; margin-bottom: 25px; border: 1px solid var(--border-color); }
        .form-section h2 { font-size: 20px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color); color: var(--secondary-color); display: flex; align-items: center; gap: 10px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-secondary); }
        input, select { width: 100%; padding: 12px; background-color: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-light); font-size: 1em; }
        .grid-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .prize-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .btn-submit { width: 100%; padding: 15px; background-color: var(--success); border: none; border-radius: 8px; color: white; font-size: 16px; cursor: pointer; transition: 0.3s; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-submit:hover { background-color: #00d2a1; transform: translateY(-2px); }
        .alert-error { background-color: rgba(214, 48, 49, 0.2); color: var(--danger); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--danger); }
        @media (max-width: 768px) { .grid-layout, .prize-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="main-content">
        <header class="header">
            <h1><i class="fas {{ $page_icon }}"></i> Add {{ ucfirst($game_type) }} Match</h1>
            <a href="{{ route('admin.matches.index', $game_type) }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back</a>
        </header>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.matches.store', $game_type) }}" method="POST">
            @csrf
            
            <div class="form-section">
                <h2><i class="fas fa-info-circle"></i> Basic Information</h2>
                <div class="grid-layout">
                    <div class="form-group">
                        <label>Match Title</label>
                        <input type="text" name="match_title" value="{{ old('match_title') }}" placeholder="e.g., PUBG Pro League" required>
                    </div>
                    <div class="form-group">
                        <label>Match Time</label>
                        <input type="datetime-local" name="match_time" value="{{ old('match_time') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-trophy"></i> Prize Pool</h2>
                <div class="form-group">
                    <label>Total Prize (BDT)</label>
                    <input type="number" name="total_prize" value="{{ old('total_prize') }}" placeholder="0" required>
                </div>
                <div class="prize-grid">
                    <div class="form-group"><label>1st Prize</label><input type="number" name="prize_1st" value="{{ old('prize_1st', 0) }}"></div>
                    <div class="form-group"><label>2nd Prize</label><input type="number" name="prize_2nd" value="{{ old('prize_2nd', 0) }}"></div>
                    <div class="form-group"><label>3rd Prize</label><input type="number" name="prize_3rd" value="{{ old('prize_3rd', 0) }}"></div>
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-cog"></i> Match Settings</h2>
                <div class="grid-layout">
                    <div class="form-group">
                        <label>Per Kill (BDT)</label>
                        <input type="number" name="per_kill" value="{{ old('per_kill', 0) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Entry Fee (BDT)</label>
                        <input type="number" name="entry_fee" value="{{ old('entry_fee') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Match Type</label>
                        <select name="match_type" required>
                            @if ($game_type == 'freefire')
                                <option value="BR MATCH">BR MATCH</option>
                                <option value="Clash Squad">Clash Squad</option>
                                <option value="FREE MATCH">FREE MATCH</option>
                            @elseif ($game_type == 'pubg')
                                <option value="Classic">Classic</option>
                                <option value="TDM 4VS4">TDM 4VS4</option>
                                <option value="FREE MATCH">FREE MATCH</option>
                            @else
                                <option value="Ludo">Ludo</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Entry Type (Solo/Duo/Squad)</label>
                        <select name="entry_type_gameplay" required>
                            <option value="Solo">Solo</option>
                            <option value="Duo">Duo</option>
                            <option value="Squad">Squad</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Version</label>
                        <select name="version" required>
                            <option value="TPP">TPP</option>
                            <option value="FPP">FPP</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Map</label>
                        <select name="play_map" required>
                            @if ($game_type == 'freefire')
                                <option value="Bermuda">Bermuda</option>
                                <option value="Kalahari">Kalahari</option>
                            @elseif ($game_type == 'pubg')
                                <option value="Erangel">Erangel</option>
                                <option value="Miramar">Miramar</option>
                                <option value="Sanhok">Sanhok</option>
                                <option value="Livik">Livik</option>
                            @else
                                <option value="Ludo Map">Ludo Map</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Total Slots (Player Need)</label>
                        <input type="number" name="player_need" value="{{ old('player_need', 100) }}" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-plus-circle"></i> Create Match Now
            </button>
        </form>
    </div>
</body>
</html>