<div class="bottom-nav">
    <div class="nav-indicator"></div>

    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <div class="icon-box">
            <i class="fas fa-home"></i>
        </div>
        <span>Home</span>
    </a>

    <a href="{{ route('my.matches') }}" class="nav-item {{ request()->routeIs('my.matches') ? 'active' : '' }}">
        <div class="icon-box">
            <i class="fas fa-gamepad"></i>
        </div>
        <span>Matches</span>
    </a>

    <a href="{{ route('leaderboard.index') }}" class="nav-item {{ request()->routeIs('leaderboard.index') ? 'active' : '' }}">
        <div class="icon-box">
            <i class="fas fa-trophy"></i>
        </div>
        <span>Rank</span>
    </a>

    <a href="{{ route('wallet.index') }}" class="nav-item {{ request()->routeIs('wallet.index') ? 'active' : '' }}">
        <div class="icon-box">
            <i class="fas fa-wallet"></i>
        </div>
        <span>Wallet</span>
    </a>

    <a href="{{ route('profile.index') }}" class="nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
        <div class="icon-box">
            <i class="fas fa-user-shield"></i>
        </div>
        <span>Profile</span>
    </a>
</div>

@once
    <style>
        :root {
            --nav-bg: rgba(10, 12, 28, 0.92);
            --neon-blue: #00f2fe;
            --neon-purple: #a855f7;
            --text-gray: #94a3b8;
        }

        .bottom-nav { 
            position: fixed; 
            bottom: 0; left: 0; right: 0; 
            background: var(--nav-bg); 
            backdrop-filter: blur(20px) saturate(180%);
            display: flex; 
            justify-content: space-around; 
            padding: 8px 10px; 
            box-shadow: 0 -10px 40px rgba(0,0,0,0.6); 
            border-top: 1px solid rgba(255, 255, 255, 0.08); 
            border-top-left-radius: 30px; 
            border-top-right-radius: 30px; 
            z-index: 10000;
            height: 70px;
        }

        .nav-item { 
            position: relative;
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center;
            color: var(--text-gray); 
            text-decoration: none; 
            width: 20%; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-family: 'Rajdhani', sans-serif;
            z-index: 1;
        }

        .icon-box {
            position: relative;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.4s;
        }

        .nav-item i { 
            font-size: 20px; 
            transition: 0.4s;
            z-index: 2;
        }

        .nav-item span {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
            opacity: 0.8;
            transition: 0.4s;
        }

        /* --- Active State Styling --- */
        .nav-item.active { 
            color: #fff;
            transform: translateY(-12px);
        }

        /* আইকনের পেছনের গ্লোয়িং সার্কেল */
        .nav-item.active .icon-box {
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            box-shadow: 0 5px 20px rgba(0, 242, 254, 0.5);
        }

        .nav-item.active i {
            color: #000;
            transform: scale(1.1);
        }

        .nav-item.active span {
            color: var(--neon-blue);
            opacity: 1;
            text-shadow: 0 0 8px rgba(0, 242, 254, 0.5);
        }

        /* ছোট্ট ইন্ডিকেটর ডট */
        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            width: 5px; height: 5px;
            background: var(--neon-blue);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--neon-blue);
        }

        /* iPhone Safe Area */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            .bottom-nav {
                height: calc(70px + env(safe-area-inset-bottom));
                padding-bottom: env(safe-area-inset-bottom);
            }
        }

        /* ক্লিক করলে ছোট এনিমেশন */
        .nav-item:active {
            transform: scale(0.9);
        }
    </style>
@endonce