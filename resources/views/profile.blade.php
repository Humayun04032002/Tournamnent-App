<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>My Profile - OX FF TOUR</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --accent: #ff007a;
            --gold: #ffd700;
            --win-green: #00ff88;
            --bg-dark: #0a0b1e;
            --glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, #1a1b3a, #0a0b1e);
            color: #fff; margin: 0; padding-bottom: 100px;
        }

        /* --- Profile Header --- */
        .profile-header {
            background: linear-gradient(180deg, rgba(0, 242, 254, 0.1) 0%, transparent 100%);
            padding: 50px 20px 30px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .avatar-container {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .avatar {
            width: 110px; height: 110px;
            border-radius: 50%;
            border: 2px solid var(--secondary);
            padding: 3px;
            background: rgba(0, 242, 254, 0.1);
            box-shadow: 0 0 25px rgba(0, 242, 254, 0.4);
            object-fit: cover;
        }

        .edit-icon {
            position: absolute; bottom: 5px; right: 5px;
            background: var(--primary); width: 28px; height: 28px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 12px; border: 2px solid var(--bg-dark);
        }

        .user-name {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            margin: 15px 0 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-shadow: 0 0 10px rgba(138, 43, 226, 0.5);
        }

        .verified-badge { width: 22px; height: 22px; filter: drop-shadow(0 0 5px rgba(255,255,255,0.3)); }
        
        /* --- Stats Row --- */
        .profile-stats {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
            margin-top: 25px;
        }
        .stat-item {
            background: rgba(255, 255, 255, 0.03);
            padding: 15px 5px;
            border-radius: 20px;
            border: 1px solid var(--border);
            backdrop-filter: blur(5px);
        }

        .stat-item.matches { border-color: var(--primary); }
        .stat-item.balance { border-color: var(--gold); }
        .stat-item.winning { border-color: var(--win-green); }

        .stat-item .value {
            display: block;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
        }
        .stat-item.matches .value { color: #d088ff; }
        .stat-item.balance .value { color: var(--gold); }
        .stat-item.winning .value { color: var(--win-green); }

        .stat-item .label {
            font-size: 0.65rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 5px;
        }

        /* --- Avatar Picker Modal --- */
        .modal {
            display: none; position: fixed; z-index: 2000; left: 0; top: 0;
            width: 100%; height: 100%; background: rgba(0,0,0,0.85);
            backdrop-filter: blur(8px); align-items: center; justify-content: center;
        }
        .modal-content {
            background: #151632; width: 85%; padding: 25px;
            border-radius: 30px; text-align: center; border: 1px solid var(--border);
        }
        .avatar-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 15px; margin: 20px 0;
        }
        .avatar-opt {
            width: 100%; aspect-ratio: 1/1; border-radius: 50%;
            border: 2px solid transparent; cursor: pointer; transition: 0.3s;
        }
        .avatar-opt.active { border-color: var(--secondary); box-shadow: 0 0 15px var(--secondary); }
        .confirm-btn {
            background: var(--primary); color: white; border: none;
            padding: 10px 30px; border-radius: 12px; font-weight: bold; font-family: 'Orbitron';
        }

        /* --- Menu List --- */
        .main-content { padding: 25px 20px; }
        .menu-list { list-style: none; padding: 0; margin: 0; }
        
        .menu-list-item a {
            display: flex; align-items: center;
            background: var(--glass);
            padding: 18px 20px;
            margin-bottom: 15px;
            border-radius: 20px;
            text-decoration: none;
            color: #eee;
            border: 1px solid var(--border);
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-list-item a i {
            font-size: 1.3rem;
            width: 40px;
            color: var(--secondary);
            filter: drop-shadow(0 0 8px rgba(0, 242, 254, 0.4));
        }

        .menu-list-item a span { font-weight: 700; font-size: 0.95rem; flex-grow: 1; letter-spacing: 0.5px; }

        .menu-list-item a::after {
            content: '\f105';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #555;
            font-size: 1.1rem;
        }

        .logout-btn {
            width: 100%;
            padding: 18px;
            margin-top: 15px;
            background: linear-gradient(45deg, #ff007a, #8a2be2);
            color: white;
            border: none;
            border-radius: 20px;
            font-family: 'Orbitron', sans-serif;
            font-weight: bold;
            letter-spacing: 2px;
            cursor: pointer;
        }

        .fab {
            position: fixed;
            width: 60px; height: 60px;
            background: var(--primary);
            border-radius: 50%;
            bottom: 90px; right: 20px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 20px var(--primary);
            z-index: 1000;
        }
        .fab i { font-size: 24px; color: white; }

    </style>
</head>
<body>

    <div class="profile-header">
        <div class="avatar-container" onclick="openAvatarModal()">
            <img src="{{ asset('assets/images/wired-flat-44-avatar-user-in-circle.gif') }}" alt="Avatar" class="avatar" id="displayAvatar">
            <div class="edit-icon"><i class="fas fa-pen"></i></div>
        </div>
        
        <h2 class="user-name">
            {{ $user->Name }}
            @if($user->Total_Played >= 10)
                <img src="{{ asset('assets/images/152875.png') }}" class="verified-badge">
            @endif
        </h2>

        <div class="profile-stats">
            <div class="stat-item matches">
                <span class="value">{{ $user->Total_Played }}</span>
                <span class="label">Matches</span>
            </div>
            <div class="stat-item balance">
                <span class="value">৳{{ number_format($user->Balance, 0) }}</span>
                <span class="label">Balance</span>
            </div>
            <div class="stat-item winning">
                <span class="value">৳{{ number_format($user->Winning, 0) }}</span>
                <span class="label">Winning</span>
            </div>
        </div>
    </div>

    <div id="avatarModal" class="modal">
        <div class="modal-content">
            <h3 style="font-family: 'Orbitron'; color: var(--secondary); font-size: 1rem;">Choose Avatar</h3>
            <div class="avatar-grid">
                <img src="{{ asset('assets/images/av1.png') }}" class="avatar-opt" onclick="selectAvatar(this)">
                <img src="{{ asset('assets/images/av2.png') }}" class="avatar-opt" onclick="selectAvatar(this)">
                <img src="{{ asset('assets/images/av3.png') }}" class="avatar-opt" onclick="selectAvatar(this)">
                <img src="{{ asset('assets/images/av4.png') }}" class="avatar-opt" onclick="selectAvatar(this)">
                <img src="{{ asset('assets/images/wired-flat-44-avatar-user-in-circle1.gif') }}" class="avatar-opt" onclick="selectAvatar(this)">
                <img src="{{ asset('assets/images/wired-flat-44-avatar-user-in-circle.gif') }}" class="avatar-opt" onclick="selectAvatar(this)">
            </div>
            <button class="confirm-btn" onclick="closeAvatarModal()">CONFIRM</button>
        </div>
    </div>

    <div class="main-content">
        <ul class="menu-list">
            <li class="menu-list-item"><a href="{{ route('wallet.index') }}"><i class="fas fa-wallet"></i><span>My Wallet</span></a></li>
            <li class="menu-list-item"><a href="{{ route('referral.index') }}"><i class="fas fa-gift"></i><span>Refer & Earn</span></a></li>
            <li class="menu-list-item"><a href="{{ route('my.matches') }}"><i class="fas fa-gamepad"></i><span>Match History</span></a></li>
            <li class="menu-list-item"><a href="{{ route('leaderboard.index') }}"><i class="fas fa-trophy"></i><span>Leaderboard</span></a></li>
            <li class="menu-list-item"><a href="{{ route('developer.info') }}"><i class="fas fa-user-shield"></i><span>Developer Info</span></a></li>
            <li class="menu-list-item"><a href="{{ asset('download/oxfftour.apk') }}"><i class="fas fa-cloud-download-alt"></i><span>Download App</span></a></li>
        </ul>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-power-off"></i> LOGOUT
            </button>
        </form>
    </div>

    <a href="{{ $supportLink }}" class="fab" target="_blank">
        <i class="fas fa-comment-dots"></i>
    </a>
    
    @include('partials.bottom-nav')

    <script>
        // পেজ লোড হলে সেভ করা ছবি দেখাবে
        document.addEventListener("DOMContentLoaded", function() {
            const savedAvatar = localStorage.getItem('selectedAvatar');
            if (savedAvatar) {
                document.getElementById('displayAvatar').src = savedAvatar;
            }
        });

        function openAvatarModal() {
            document.getElementById('avatarModal').style.display = 'flex';
        }

        function closeAvatarModal() {
            document.getElementById('avatarModal').style.display = 'none';
        }

        function selectAvatar(element) {
            const newAvatarSrc = element.src;
            // মেইন ডিসপ্লে আপডেট
            document.getElementById('displayAvatar').src = newAvatarSrc;
            
            // লোকাল স্টোরেজে সেভ (রিফ্রেশ দিলে হারাবে না)
            localStorage.setItem('selectedAvatar', newAvatarSrc);
            
            // হাইলাইট আপডেট
            document.querySelectorAll('.avatar-opt').forEach(img => img.classList.remove('active'));
            element.classList.add('active');
        }

        window.onclick = function(event) {
            let modal = document.getElementById('avatarModal');
            if (event.target == modal) closeAvatarModal();
        }
    </script>
</body>
</html>