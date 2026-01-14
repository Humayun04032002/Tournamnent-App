<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Edit Match: {{ $match->Match_Title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6C5CE7; --secondary-color: #A29BFE; --bg-dark: #0F0F1A;
            --bg-light-dark: #1D1D30; --text-light: #F5F6FA; --text-secondary: #A29BFE;
            --border-color: rgba(255, 255, 255, 0.1); --success: #00B894; --warning: #FF9800;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-light); min-height: 100vh; padding-bottom: 50px; }
        .main-content { padding: 30px 20px; max-width: 1000px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
        .header h1 { font-size: 24px; font-weight: 600; display: flex; align-items: center; gap: 12px; }
        .header h1 i { color: var(--primary-color); }
        .btn-back { text-decoration: none; color: var(--text-secondary); background-color: var(--bg-light-dark); border: 1px solid var(--border-color); padding: 10px 20px; border-radius: 8px; transition: all 0.3s; display: flex; align-items:center; gap: 8px; font-size: 14px; }
        .btn-back:hover { background-color: var(--primary-color); color: white; transform: translateX(-5px); }
        .form-section { background-color: var(--bg-light-dark); border-radius: 15px; padding: 30px; margin-bottom: 25px; border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .form-section h2 { font-size: 18px; margin-bottom: 25px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); color: var(--secondary-color); display: flex; align-items:center; gap: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .form-group { margin-bottom: 22px; }
        .form-group label { display: block; margin-bottom: 10px; font-weight: 500; color: var(--text-secondary); font-size: 14px; }
        input[type="text"], input[type="number"], input[type="datetime-local"], select { 
            width: 100%; padding: 14px; background-color: var(--bg-dark); border: 1px solid var(--border-color); 
            border-radius: 10px; color: var(--text-light); font-size: 15px; transition: border-color 0.3s; outline: none;
        }
        input:focus, select:focus { border-color: var(--primary-color); }
        .grid-layout { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .btn-save { 
            width: 100%; padding: 16px; background: linear-gradient(135deg, var(--primary-color), #4834d4); 
            border: none; border-radius: 12px; color: white; font-size: 18px; cursor: pointer; 
            display: flex; align-items: center; justify-content: center; gap: 12px; font-weight: 600; 
            transition: all 0.3s; box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(108, 92, 231, 0.5); filter: brightness(1.1); }
        .alert { padding: 15px 25px; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; border-left: 5px solid transparent; }
        .alert-success { background-color: rgba(0, 184, 148, 0.15); color: #55efc4; border-left-color: var(--success); }
        .alert-error { background-color: rgba(214, 48, 49, 0.15); color: #ff7675; border-left-color: #d63031; }
        @media (max-width: 600px) { .grid-layout { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="main-content">
        <header class="header">
            <h1><i class="fas fa-edit"></i> Edit {{ ucfirst($game_type) }} Match</h1>
            <a href="{{ route('admin.matches.index', $game_type) }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back to List</a>
        </header>

        <main>
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.matches.update', ['game_type' => $game_type, 'match' => $match->id]) }}" method="post">
                @csrf
                @method('PUT')
                
                <div class="form-section">
                    <h2><i class="fas fa-info-circle"></i> Match Identity</h2>
                    <div class="form-group">
                        <label>Match Title</label>
                        <input type="text" name="Match_Title" value="{{ old('Match_Title', $match->Match_Title) }}" required>
                    </div>
                    
                    <div class="grid-layout">
                        <div class="form-group">
                            <label>Match Time</label>
                            <input type="datetime-local" name="Match_Time" value="{{ \Carbon\Carbon::parse($match->Match_Time)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Match Status / Position</label>
                            <select name="Position">
                                <option value="Match" @selected(old('Position', $match->Position) == 'Match')>Upcoming (Match)</option>
                                <option value="OnGoing" @selected(old('Position', $match->Position) == 'OnGoing')>Live / OnGoing</option>
                                <option value="Result" @selected(old('Position', $match->Position) == 'Result')>Completed (Result)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-gamepad"></i> Game Settings</h2>
                    <div class="grid-layout">
                        <div class="form-group">
                            <label>Map</label>
                            <input type="text" name="Play_Map" value="{{ old('Play_Map', $match->Play_Map) }}" placeholder="e.g. Erangel / Bermuda">
                        </div>
                        <div class="form-group">
                            <label>Version</label>
                            <input type="text" name="Version" value="{{ old('Version', $match->Version) }}" placeholder="e.g. TPP / Clash Squad">
                        </div>
                        <div class="form-group">
                            <label>Entry Type (Solo/Duo/Squad)</label>
                            <select name="Entry_Type">
                                <option value="Solo" @selected(old('Entry_Type', $match->Entry_Type) == 'Solo')>Solo</option>
                                <option value="Duo" @selected(old('Entry_Type', $match->Entry_Type) == 'Duo')>Duo</option>
                                <option value="Squad" @selected(old('Entry_Type', $match->Entry_Type) == 'Squad')>Squad</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-money-bill-wave"></i> Prize & Entry</h2>
                    <div class="grid-layout">
                        <div class="form-group"><label>Total Prize (BDT)</label><input type="number" name="Total_Prize" value="{{ old('Total_Prize', $match->Total_Prize) }}"></div>
                        <div class="form-group"><label>Per Kill (BDT)</label><input type="number" name="Per_Kill" value="{{ old('Per_Kill', $match->Per_Kill) }}"></div>
                        <div class="form-group"><label>Entry Fee (BDT)</label><input type="number" name="Entry_Fee" value="{{ old('Entry_Fee', $match->Entry_Fee) }}"></div>
                        <div class="form-group"><label>Required Players (Slots)</label><input type="number" name="Player_Need" value="{{ old('Player_Need', $match->Player_Need) }}"></div>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-key"></i> Room Details</h2>
                    <p style="font-size: 12px; color: var(--warning); margin-bottom: 15px; margin-top: -10px;">
                        <i class="fas fa-shield-alt"></i> ID and Pass will be hidden until match starts.
                    </p>
                    <div class="grid-layout">
                        <div class="form-group"><label>Room ID</label><input type="text" name="Room_ID" value="{{ old('Room_ID', $match->Room_ID) }}" placeholder="Wait for Match..."></div>
                        <div class="form-group"><label>Room Password</label><input type="text" name="Room_Pass" value="{{ old('Room_Pass', $match->Room_Pass) }}" placeholder="Wait for Match..."></div>
                    </div>
                </div>

                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </main>
    </div>
</body>
</html>