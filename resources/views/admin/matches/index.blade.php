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
            --primary-color: #6C5CE7; --secondary-color: #A29BFE; --bg-dark: #0F0F1A;
            --bg-light-dark: #1D1D30; --text-light: #F5F6FA; --text-secondary: #A29BFE;
            --border-color: rgba(255, 255, 255, 0.1); --success: #00B894; --danger: #D63031;
            --warning: #FF9800; --live: #E84393; --info: #00CEC9;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-light); }
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 30px 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px; }
        .header h1 { font-size: 28px; font-weight: 600; }
        .header-actions { display: flex; gap: 15px; }
        .btn { text-decoration: none; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 500; transition: all 0.3s; display: flex; align-items: center; gap: 8px; border: none; cursor: pointer; }
        .btn-create { background: linear-gradient(135deg, var(--primary-color), #4834d4); }
        .btn-back { background-color: var(--bg-light-dark); border: 1px solid var(--border-color); color: var(--text-secondary); }
        .btn-back:hover { background-color: var(--primary-color); color: white; }

        .tabs { display: flex; justify-content: center; gap: 10px; border-bottom: 1px solid var(--border-color); margin-bottom: 30px; }
        .tab-link { padding: 12px 25px; cursor: pointer; border: none; background: none; font-size: 16px; font-weight: 600; color: var(--text-secondary); border-bottom: 3px solid transparent; transition: all 0.3s; }
        .tab-link.active { border-bottom-color: var(--primary-color); color: var(--text-light); }
        .tab-content { display: none; animation: fadeIn 0.4s ease-out; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .matches-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 25px; }
        .match-card { background-color: var(--bg-light-dark); border-radius: 15px; border-left: 5px solid var(--primary-color); padding: 25px; display: flex; flex-direction: column; gap: 15px; transition: 0.3s; position: relative; border-top: 1px solid var(--border-color); border-right: 1px solid var(--border-color); }
        .match-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        .match-card.live { border-left-color: var(--live); }
        .match-card.completed { border-left-color: var(--success); opacity: 0.85; }
        
        .card-header { display: flex; justify-content: space-between; align-items: flex-start; }
        .card-header h3 { font-size: 18px; color: var(--text-light); line-height: 1.3; }
        
        .match-status { font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; }
        .status-live { background-color: var(--live); color: white; animation: pulse 1.5s infinite; }
        .status-upcoming { background-color: var(--info); color: white; }
        .status-completed { background-color: var(--success); color: white; }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(232, 67, 147, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(232, 67, 147, 0); } 100% { box-shadow: 0 0 0 0 rgba(232, 67, 147, 0); } }

        .card-meta { display: flex; justify-content: space-between; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 8px; font-size: 12px; color: var(--text-secondary); }
        .card-meta b { color: var(--secondary-color); }

        .card-details { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; padding: 10px 0; border-top: 1px dashed var(--border-color); border-bottom: 1px dashed var(--border-color); }
        .detail-item { text-align: center; }
        .detail-item span { display: block; font-size: 10px; color: var(--text-secondary); margin-bottom: 2px; }
        .detail-item strong { font-size: 13px; color: var(--text-light); }

        .card-actions { display: flex; gap: 8px; margin-top: 10px; }
        .action-btn { flex: 1; text-decoration: none; padding: 10px; border-radius: 8px; font-size: 12px; font-weight: 600; text-align: center; color: white; transition: 0.2s; border: none; cursor: pointer; }
        .btn-edit { background-color: #4834d4; }
        .btn-joiners { background-color: var(--warning); color: #111; }
        .btn-result { background-color: var(--success); }
        .btn-delete { background-color: var(--danger); flex: 0.4; }
        .action-btn:hover { filter: brightness(1.2); }

        .no-match { grid-column: 1/-1; text-align: center; padding: 60px; background: var(--bg-light-dark); border-radius: 15px; color: var(--text-secondary); border: 1px dashed var(--border-color); }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-title-wrapper">
                <h1><i class="fas {{ $page_icon }}"></i> {{ $page_title }}</h1>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-back"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('admin.matches.create', $game_type) }}" class="btn btn-create"><i class="fas fa-plus-circle"></i> Create New</a>
            </div>
        </header>

        <main>
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'Upcoming')">Active Matches</button>
                <button class="tab-link" onclick="openTab(event, 'Completed')">History</button>
            </div>

            <div id="Upcoming" class="tab-content active">
                <div class="matches-grid">
                    @php
                        // Controller থেকে আসা $all_matches কালেকশন থেকে OnGoing এবং Match গ্রুপ আলাদা করা
                        $live_matches = $all_matches->get('OnGoing', collect());
                        $upcoming_matches = $all_matches->get('Match', collect());
                        $active_list = $live_matches->merge($upcoming_matches);
                    @endphp

                    @forelse ($active_list as $match)
                        <div class="match-card {{ $match->Position == 'OnGoing' ? 'live' : '' }}">
                            <div class="card-header">
                                <h3>{{ $match->Match_Title }}</h3>
                                <span class="match-status {{ $match->Position == 'OnGoing' ? 'status-live' : 'status-upcoming' }}">
                                    {{ $match->Position == 'OnGoing' ? 'Live' : 'Upcoming' }}
                                </span>
                            </div>

                            <div class="card-meta">
                                <span><i class="fas fa-map"></i> <b>{{ $match->Play_Map }}</b></span>
                                <span><i class="fas fa-user-tag"></i> <b>{{ $match->Entry_Type }}</b></span>
                                <span><i class="fas fa-code-branch"></i> <b>{{ $match->Version }}</b></span>
                            </div>

                            <div class="card-details">
                                <div class="detail-item">
                                    <span>Schedule</span>
                                    <strong>{{ \Carbon\Carbon::parse($match->Match_Time)->format('d M, h:i A') }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span>Joined</span>
                                    <strong>{{ $match->Player_Join }} / {{ $match->Player_Need }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span>Prize</span>
                                    <strong>{{ $match->Total_Prize }} ৳</strong>
                                </div>
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('admin.matches.edit', ['game_type' => $game_type, 'match' => $match->id]) }}" class="action-btn btn-edit" title="Edit Match"><i class="fas fa-edit"></i></a>
                                
                                <a href="{{ route('admin.matches.joiners', ['game_type' => $game_type, 'match_key' => $match->Match_Key]) }}" class="action-btn btn-joiners"><i class="fas fa-users"></i> Joiners</a>
                                
                                <a href="{{ route('admin.matches.result.form', ['game_type' => $game_type, 'match_key' => $match->Match_Key]) }}" class="action-btn btn-result"><i class="fas fa-trophy"></i> Result</a>
                                
                                <form action="{{ route('admin.matches.destroy', ['game_type' => $game_type, 'match' => $match->id]) }}" method="POST" onsubmit="return confirm('Permanently delete this match?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="no-match">
                            <i class="fas fa-calendar-times fa-3x" style="margin-bottom:15px; opacity:0.3"></i>
                            <p>No active matches found for {{ ucfirst($game_type) }}.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div id="Completed" class="tab-content">
                <div class="matches-grid">
                    @forelse ($all_matches->get('Result', collect()) as $match)
                        <div class="match-card completed">
                            <div class="card-header">
                                <h3>{{ $match->Match_Title }}</h3>
                                <span class="match-status status-completed">Finished</span>
                            </div>
                            
                            <div class="card-meta">
                                <span>Date: <b>{{ \Carbon\Carbon::parse($match->Match_Time)->format('d M, Y') }}</b></span>
                                <span>Joined: <b>{{ $match->Player_Join }}</b></span>
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('admin.matches.joiners', ['game_type' => $game_type, 'match_key' => $match->Match_Key]) }}" class="action-btn btn-joiners" style="flex: 2;"><i class="fas fa-poll"></i> View Results</a>
                                
                                <form action="{{ route('admin.matches.destroy', ['game_type' => $game_type, 'match' => $match->id]) }}" method="POST" onsubmit="return confirm('Delete history?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="no-match">
                            <p>No finished matches found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-link");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
    </script>
</body>
</html>