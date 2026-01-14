<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Joined Players - {{ $match->Match_Title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --bg-dark: #070916;
            --card-glass: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.08);
            --accent: #6C5CE7;
        }

        body { 
            font-family: 'Rajdhani', sans-serif; 
            margin: 0; 
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at 50% 0%, #1a1b3d 0%, #070916 70%);
            color: #fff; 
            padding-bottom: 40px;
        }

        .container { max-width: 800px; margin: 0 auto; padding: 15px; }

        /* --- Header Styling --- */
        .header-box {
            text-align: center;
            padding: 30px 15px;
            margin-bottom: 20px;
        }

        .header-box h1 { 
            font-family: 'Orbitron'; 
            font-size: 1.5rem; 
            color: var(--secondary); 
            text-transform: uppercase;
            margin: 10px 0;
            letter-spacing: 1px;
            text-shadow: 0 0 15px rgba(0, 242, 254, 0.3);
        }

        /* --- Back Button --- */
        .btn-back { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px;
            padding: 10px 18px; 
            background: var(--card-glass); 
            color: white; 
            text-decoration: none; 
            border-radius: 12px; 
            border: 1px solid var(--border);
            transition: 0.3s; 
            font-weight: 700;
            font-size: 0.9rem;
        }
        .btn-back:active { transform: scale(0.95); background: rgba(255,255,255,0.1); }

        /* --- Table Styling --- */
        .table-container { 
            background: var(--card-glass); 
            border-radius: 20px; 
            padding: 5px; 
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
            margin-bottom: 25px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        
        th { 
            background: rgba(255, 255, 255, 0.05);
            font-family: 'Orbitron';
            text-transform: uppercase; 
            font-weight: 600; 
            font-size: 0.75rem; 
            color: var(--secondary);
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        td { 
            padding: 14px 15px; 
            font-size: 1rem; 
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03); 
        }

        tr:last-child td { border-bottom: none; }
        
        tr:nth-child(even) { background: rgba(255, 255, 255, 0.01); }

        .player-count {
            display: inline-block;
            background: var(--accent);
            padding: 2px 10px;
            border-radius: 6px;
            font-family: 'Orbitron';
            font-size: 0.8rem;
            margin-bottom: 5px;
        }

        /* --- Rules Section --- */
        .rules-section { 
            background: var(--card-glass); 
            padding: 20px; 
            border-radius: 20px; 
            border: 1px solid var(--border);
            border-top: 3px solid var(--accent);
        }

        .rules-section h3 { 
            font-family: 'Orbitron'; 
            color: var(--accent); 
            margin-top: 0; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-size: 1rem;
        }

        .rules-content {
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 12px;
            font-size: 0.9rem;
            line-height: 1.6;
            color: #ccc;
            white-space: pre-wrap;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .no-data { text-align: center; padding: 40px 0; color: #555; }

        /* --- Animations --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-container, .rules-section {
            animation: fadeInUp 0.5s ease-out forwards;
        }

    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('matches.list', ['type' => $match->Match_Type]) }}" class="btn-back">
            <i class="fas fa-chevron-left"></i> Back
        </a>

        <div class="header-box">
            <div class="player-count">
                <i class="fas fa-users"></i> {{ count($joiners) }} Joined
            </div>
            <h1>{{ $match->Match_Title }}</h1>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Player Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($joiners as $index => $joiner)
                        <tr>
                            <td style="color: var(--secondary); font-family: 'Orbitron';">{{ $index + 1 }}</td>
                            <td>
                                <i class="fas fa-user-ninja" style="margin-right: 8px; font-size: 0.8rem; color: #777;"></i>
                                {{ $joiner->ingame_name }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="no-data">
                                <i class="fas fa-ghost" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                No players joined yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="rules-section">
            <h3><i class="fas fa-shield-halved"></i> Rules & Regulations</h3>
            <div class="rules-content">{{ $rulesText }}</div>
        </div>
    </div>
</body>
</html>