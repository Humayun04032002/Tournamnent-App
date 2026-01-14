<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <title>Dashboard - {{ $site_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #8A2BE2; --secondary-color: #4A90E2; --bg-dark: #0a0a14;
            --bg-light-dark: #141421; --text-light: #f0f0f0; --text-secondary: #a0a0b0;
            --border-color: rgba(255, 255, 255, 0.1); --success: #28a745; --danger: #dc3545;
            --warning: #f39c12; --info: #17a2b8;
        }
        @property --gradient-angle { syntax: "<angle>"; initial-value: 0deg; inherits: false; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-light); background-image: radial-gradient(circle at 1% 1%, rgba(138, 43, 226, 0.15), transparent 30%), radial-gradient(circle at 99% 99%, rgba(74, 144, 226, 0.15), transparent 30%); min-height: 100vh; }
        
        .navbar { background: rgba(10, 10, 20, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); padding: 0 40px; display: flex; justify-content: space-between; align-items: center; height: 75px; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 100; }
        .navbar-brand { font-size: 24px; font-weight: 700; color: var(--text-light); text-decoration: none; display: flex; align-items: center; gap: 12px; }
        .navbar-brand i { color: var(--primary-color); }
        .navbar-actions { display: flex; align-items: center; gap: 15px; }
        
        .btn-action { background-color: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); padding: 10px 18px; border-radius: 8px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; text-decoration: none; font-weight: 500; }
        .btn-action:hover { background-color: var(--primary-color); color: white; border-color: var(--primary-color); transform: translateY(-2px); }
        .btn-action.logout-btn { border-color: var(--danger); color: var(--danger); }
        .btn-action.logout-btn:hover { background-color: var(--danger); color: white; }
        
        .main-container { padding: 40px; max-width: 1400px; margin: 0 auto; }
        .page-header { text-align: center; margin-bottom: 40px; animation: fadeInDown 0.8s ease-out; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .page-header h1 { font-size: 36px; font-weight: 800; background: linear-gradient(90deg, var(--primary-color), var(--secondary-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .page-header p { font-size: 16px; color: var(--text-secondary); }

        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: var(--bg-light-dark); padding: 20px; border-radius: 16px; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 15px; transition: 0.3s; }
        .stat-card:hover { border-color: var(--primary-color); transform: translateY(-5px); }
        .stat-card i { width: 50px; height: 50px; border-radius: 12px; display: grid; place-items: center; font-size: 20px; }
        .stat-info h4 { font-size: 20px; font-weight: 700; color: #fff; margin: 0; }
        .stat-info p { font-size: 11px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 2px; letter-spacing: 0.5px; }

        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 25px; justify-content: center; }
        .d-card { aspect-ratio: 1 / 1; text-decoration: none; color: var(--text-light); background-color: var(--bg-light-dark); border-radius: 20px; position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; cursor: pointer; transition: 0.3s; animation: popIn 0.6s ease-out forwards; opacity: 0; transform: scale(0.9); animation-delay: calc(var(--delay) * 100ms); overflow: hidden; border: 1px solid var(--border-color); }
        @keyframes popIn { to { opacity: 1; transform: scale(1); } }
        
        .d-card::before { content: ''; position: absolute; top: 50%; left: 50%; width: 200%; height: 200%; border-radius: inherit; z-index: 0; transform: translate(-50%, -50%); background: conic-gradient(from var(--gradient-angle), var(--primary-color), var(--secondary-color) 25%, var(--primary-color) 50%); animation: spin 4s linear infinite paused; opacity: 0.5; }
        .d-card::after { content: ''; position: absolute; background: var(--bg-light-dark); inset: 2px; border-radius: 18px; z-index: 0; }
        .d-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.5); border-color: var(--primary-color); }
        .d-card:hover::before { animation-play-state: running; }
        @keyframes spin { to { --gradient-angle: 360deg; } }
        
        .card-content { z-index: 1; text-align: center; display: flex; flex-direction: column; align-items: center; }
        .icon-wrapper { width: 50px; height: 50px; border-radius: 50%; display: grid; place-items: center; margin-bottom: 12px; font-size: 24px; transition: 0.3s; }
        .card-title { font-size: 15px; font-weight: 600; }
        .card-count { font-size: 26px; font-weight: 700; margin-top: 2px; }
        .card-subtext { font-size: 11px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; }
        .pending-badge { position: absolute; top: 15px; right: 15px; background: var(--danger); color: white; font-size: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 800; z-index: 5; box-shadow: 0 0 10px rgba(220,53,69,0.5); }

        .modal { visibility: hidden; opacity: 0; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; transition: 0.3s; }
        .modal.is-visible { visibility: visible; opacity: 1; }
        .modal-content { background-color: var(--bg-light-dark); padding: 35px; border: 1px solid var(--border-color); width: 90%; max-width: 450px; border-radius: 20px; position: relative; }
        
        @media (max-width: 768px) {
            .navbar { padding: 0 20px; }
            .main-container { padding: 20px; }
            .dashboard-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
            .stats-row { grid-template-columns: 1fr 1fr; }
            .page-header h1 { font-size: 28px; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand"><i class="fas fa-shield-halved"></i><span>{{ $site_name }}</span></a>
        <div class="navbar-actions">
            <button id="changePasswordBtn" class="btn-action"><i class="fas fa-key"></i> <span>Pass</span></button>
            <form action="{{ route('admin.logout') }}" method="post" style="display: inline;">
                @csrf
                <button type="submit" class="btn-action logout-btn"><i class="fas fa-power-off"></i></button>
            </form>
        </div>
    </nav>

    <div class="main-container">
        <header class="page-header">
            <h1>Admin Control Hub</h1>
            <p>Welcome, <b>{{ Auth::guard('admin')->user()->username }}</b>. All systems are operational.</p>
        </header>

        <div class="stats-row">
            <div class="stat-card">
                <i class="fas fa-coins" style="background: rgba(40, 167, 69, 0.15); color: var(--success);"></i>
                <div class="stat-info">
                    <p>Today Deposits</p>
                    <h4>{{ number_format($today_deposits) }} ৳</h4>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-money-bill-transfer" style="background: rgba(220, 53, 69, 0.15); color: var(--danger);"></i>
                <div class="stat-info">
                    <p>Today Withdraw</p>
                    <h4>{{ number_format($today_withdrawals) }} ৳</h4>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-user-plus" style="background: rgba(52, 152, 219, 0.15); color: var(--secondary-color);"></i>
                <div class="stat-info">
                    <p>New Players Today</p>
                    <h4>+{{ $new_users_today }}</h4>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-fire" style="background: rgba(243, 156, 18, 0.15); color: var(--warning);"></i>
                <div class="stat-info">
                    <p>Active Matches</p>
                    <h4>{{ $active_matches }}</h4>
                </div>
            </div>
        </div>

        <main class="dashboard-grid">
            @php
            $cards = [
                ['route' => route('admin.users.index'), 'icon' => 'fa-users', 'color' => '#3498db', 'title' => 'Users', 'count' => $total_users, 'sub' => 'Total Players'],
                ['route' => route('admin.transactions.index', ['type' => 'addmoney']), 'icon' => 'fa-wallet', 'color' => '#2ecc71', 'title' => 'Add Money', 'count' => $pending_addmoney, 'sub' => 'Pending', 'badge' => true],
                ['route' => route('admin.transactions.index', ['type' => 'withdraw']), 'icon' => 'fa-hand-holding-dollar', 'color' => '#e74c3c', 'title' => 'Withdraw', 'count' => $pending_withdraw, 'sub' => 'Pending', 'badge' => true],
                
                // Matches Management
                ['route' => route('admin.matches.index', ['game_type' => 'freefire']), 'icon' => 'fa-crosshairs', 'color' => '#f39c12', 'title' => 'FF Matches', 'sub' => 'Manage'],
                ['route' => route('admin.matches.index', ['game_type' => 'pubg']), 'icon' => 'fa-gun', 'color' => '#FF5722', 'title' => 'PUBG', 'sub' => 'Manage'],
                ['route' => route('admin.matches.index', ['game_type' => 'ludo']), 'icon' => 'fa-dice', 'color' => '#1abc9c', 'title' => 'Ludo', 'sub' => 'Manage'],
                
                // App Config
                ['route' => route('admin.sliders.index'), 'icon' => 'fa-images', 'color' => '#9b59b6', 'title' => 'Sliders', 'sub' => 'Banners'],
                ['route' => route('admin.notifications.form'), 'icon' => 'fa-bell', 'color' => '#E91E63', 'title' => 'Notification', 'sub' => 'Push Msg'],
                ['route' => route('admin.rules.index'), 'icon' => 'fa-scroll', 'color' => '#34495e', 'title' => 'Rules', 'sub' => 'Setup'],
                ['route' => route('admin.settings.index'), 'icon' => 'fa-cog', 'color' => '#7f8c8d', 'title' => 'Settings', 'sub' => 'Config']
            ];
            @endphp

            @foreach ($cards as $i => $card)
            <a href="{{ $card['route'] }}" class="d-card" style="--delay: {{ $i }}">
                @if (isset($card['badge']) && $card['count'] > 0)
                    <span class="pending-badge">{{ $card['count'] }}</span>
                @endif
                <div class="card-content">
                    <div class="icon-wrapper" style="color: {{ $card['color'] }}; filter: drop-shadow(0 0 10px {{ $card['color'] }}B3);">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                    <h3 class="card-title">{{ $card['title'] }}</h3>
                    @if (isset($card['count']))
                        <p class="card-count">{{ $card['count'] }}</p>
                        <p class="card-subtext">{{ $card['sub'] }}</p>
                    @else
                        <p class="card-subtext" style="margin-top: 4px;">{{ $card['sub'] }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </main>
    </div>

    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 style="font-size: 20px;">Change Password</h2>
                <i class="fas fa-times" id="closeModal" style="cursor:pointer; font-size: 20px;"></i>
            </div>

            @if ($errors->any())
                <div style="background: rgba(220,53,69,0.1); color: var(--danger); padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px;">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.password.change') }}" method="post">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; font-size:13px;">Current Password</label>
                    <input type="password" name="current_password" style="width:100%; padding:12px; background:var(--bg-dark); border:1px solid var(--border-color); border-radius:8px; color:#fff;" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom:5px; font-size:13px;">New Password</label>
                    <input type="password" name="new_password" style="width:100%; padding:12px; background:var(--bg-dark); border:1px solid var(--border-color); border-radius:8px; color:#fff;" required>
                </div>
                <button type="submit" class="btn-action" style="width:100%; background:var(--primary-color); color:#fff; border:none; padding:15px; justify-content:center; font-weight:600;">Update Securely</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById("passwordModal");
            const openBtn = document.getElementById("changePasswordBtn");
            const closeBtn = document.getElementById("closeModal");

            if(openBtn) {
                openBtn.onclick = () => modal.classList.add('is-visible');
            }
            if(closeBtn) {
                closeBtn.onclick = () => modal.classList.remove('is-visible');
            }
            window.onclick = (e) => { if(e.target === modal) modal.classList.remove('is-visible'); }

            @if ($errors->any() || session('status_success'))
                modal.classList.add('is-visible');
            @endif
        });
    </script>
</body>
</html>