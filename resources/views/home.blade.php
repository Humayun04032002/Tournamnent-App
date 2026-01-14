<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home - OX FF TOUR</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --accent: #ff007a;
            --bg-dark: #0a0b1e;
            --card-bg: rgba(255, 255, 255, 0.05);
            --glass: rgba(255, 255, 255, 0.08);
            --text-main: #ffffff;
            --text-dim: #b0b0b0;
            --grad-pro: linear-gradient(135deg, #8a2be2, #4b0082);
            --neon-shadow: 0 0 15px rgba(138, 43, 226, 0.4);
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        body {
            margin: 0;
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, #1a1b3a, #0a0b1e);
            color: var(--text-main);
            padding-bottom: 100px;
            overflow-x: hidden;
        }

        .main-container { padding: 18px; }

        /* ================= PREMIUM SLIDER ================= */
        .slider-container {
            position: relative; width: 100%; aspect-ratio: 16/8.5;
            border-radius: 20px; overflow: hidden;
            border: 2px solid var(--glass);
            box-shadow: var(--neon-shadow);
            margin-bottom: 25px;
        }
        .view-pager { display: flex; height: 100%; transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .slide { min-width: 100%; position: relative; }
        .slide img { width: 100%; height: 100%; object-fit: cover; }
        .slide::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 11, 30, 0.8), transparent); }

        .dots-container {
            position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%);
            display: flex; gap: 8px; background: rgba(0, 0, 0, 0.4);
            padding: 5px 12px; border-radius: 20px; backdrop-filter: blur(5px);
        }
        .dot { width: 6px; height: 6px; background: rgba(255, 255, 255, 0.3); border-radius: 50%; transition: 0.3s; }
        .dot.active { width: 18px; background: var(--secondary); border-radius: 10px; }

        /* ================= NEON NOTICE BAR ================= */
        .notice-bar {
            display: flex; align-items: center; gap: 12px;
            background: var(--glass); padding: 10px 15px;
            border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px); margin-bottom: 25px;
            position: relative; overflow: hidden;
        }
        .notice-bar::before {
            content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 4px;
            background: var(--secondary); box-shadow: 0 0 10px var(--secondary);
        }
        .notice-icon { font-size: 1.2rem; color: var(--secondary); animation: ring 2s infinite; }
        @keyframes ring { 0%, 100% { transform: rotate(0); } 25% { transform: rotate(15deg); } 75% { transform: rotate(-15deg); } }
        .marquee { overflow: hidden; white-space: nowrap; font-weight: 500; font-size: 0.95rem; flex: 1; }
        .marquee span { display: inline-block; padding-left: 100%; animation: mar 18s linear infinite; color: #e0e0e0; }

        /* ================= PRO SECTIONS ================= */
        .section-header {
            font-family: 'Orbitron', sans-serif; font-size: 1.1rem;
            font-weight: 700; color: var(--secondary);
            margin: 35px 0 15px; display: flex; align-items: center; gap: 10px;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .section-header i { font-size: 0.9rem; color: var(--accent); }

        /* ================= GAMING CARDS ================= */
        .match-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .game-card {
            text-decoration: none; background: var(--card-bg);
            border-radius: 18px; overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }
        .game-card:active { transform: scale(0.95); border-color: var(--secondary); }

        .banner {
            aspect-ratio: 1/1; background-size: cover; background-position: center;
            position: relative; transition: 0.5s;
        }
        .game-card:hover .banner { transform: scale(1.1); }
        .banner::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to bottom, transparent, rgba(10, 11, 30, 0.9)); }

        .card-tag {
            position: absolute; top: 10px; left: 10px;
            background: var(--accent); color: white;
            font-size: 0.65rem; padding: 3px 8px; border-radius: 5px;
            font-weight: 700; z-index: 2; box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .info { padding: 12px; text-align: center; background: rgba(0,0,0,0.3); }
        .title { font-size: 0.95rem; font-weight: 700; margin: 0; color: #fff; letter-spacing: 0.5px; }
        .count { font-size: 0.75rem; color: var(--secondary); margin-top: 4px; font-weight: 600; }

        /* ================= LIVE VIDEO ================= */
        .video-container {
            position: relative; padding: 3px;
            background: linear-gradient(45deg, var(--primary), var(--secondary), var(--accent));
            border-radius: 18px; animation: borderRotate 4s linear infinite; background-size: 200% 200%;
        }
        @keyframes borderRotate {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .video-wrapper { position: relative; padding-bottom: 56.25%; overflow: hidden; border-radius: 16px; background: #000; }
        .video-wrapper iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }

        /* ================= FLOATING ACTION ================= */
        .fab {
            position: fixed; right: 20px; bottom: 95px;
            width: 55px; height: 55px; border-radius: 50%;
            background: var(--grad-pro); display: flex; justify-content: center; align-items: center;
            color: #fff; font-size: 24px; text-decoration: none;
            box-shadow: 0 8px 25px rgba(138, 43, 226, 0.5); z-index: 99;
        }

        @keyframes mar { to { transform: translateX(-100%); } }
    </style>
</head>

<body>

<div class="main-container">

    <div class="slider-container">
        @if($sliders->isNotEmpty())
        <div class="view-pager" id="viewPager">
            @foreach($sliders as $slide)
            <div class="slide">
                <a href="{{ $slide->link ?? '#' }}"><img src="{{ $slide->img }}"></a>
            </div>
            @endforeach
        </div>
        <div class="dots-container" id="dotsContainer"></div>
        @else
        <div style="text-align:center; padding:20px; color:var(--text-dim)">No Active Promos</div>
        @endif
    </div>

    <div class="notice-bar">
        <i class="fas fa-bullhorn notice-icon"></i>
        <div class="marquee"><span>{{ $noticeText }}</span></div>
    </div>

    <h2 class="section-header"><i class="fas fa-fire"></i> FREE FIRE ARENA</h2>
    <div class="match-grid">
        <a href="{{ route('matches.list',['type'=>'br_match']) }}" class="game-card">
            <span class="card-tag">MOBILE</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/IMG_20251113_175119_665.jpeg') }}')"></div>
            <div class="info">
                <p class="title">BR SQUAD</p>
                <p class="count"><i class="fas fa-gamepad"></i> {{ $gameCounts['br_match'] }} Matches</p>
            </div>
        </a>
        <a href="{{ route('matches.list',['type'=>'clash_squad']) }}" class="game-card">
            <span class="card-tag">CS MODE</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/IMG_20251113_175156_516.jpeg') }}')"></div>
            <div class="info">
                <p class="title">CLASH SQUAD</p>
                <p class="count"><i class="fas fa-gamepad"></i> {{ $gameCounts['clash_squad'] }} Matches</p>
            </div>
        </a>
        <a href="{{ route('matches.list',['type'=>'lone_wolf']) }}" class="game-card">
            <span class="card-tag">1 VS 1</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/IMG_20251113_174616_636.jpeg') }}')"></div>
            <div class="info">
                <p class="title">LONE WOLF</p>
                <p class="count"><i class="fas fa-gamepad"></i> {{ $gameCounts['lone_wolf'] }} Matches</p>
            </div>
        </a>
        <a href="{{ route('matches.list',['type'=>'free_match']) }}" class="game-card">
            <span class="card-tag">GIVEAWAY</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/IMG_20251113_175135_559.jpeg') }}')"></div>
            <div class="info">
                <p class="title">FREE MATCH</p>
                <p class="count"><i class="fas fa-gift"></i> {{ $gameCounts['free_match'] }} Matches</p>
            </div>
        </a>
    </div>

    <h2 class="section-header" style="color: #fbc02d;"><i class="fas fa-crosshairs"></i> PUBG MOBILE</h2>
    <div class="match-grid">
        <a href="{{ route('matches.list',['type'=>'pubg_solo']) }}" class="game-card">
            <span class="card-tag" style="background:#fbc02d">SOLO</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/pubg_solo.jpeg') }}')"></div>
            <div class="info">
                <p class="title">SOLO MATCH</p>
                <p class="count">{{ $gameCounts['pubg_solo'] ?? 0 }} Matches</p>
            </div>
        </a>
        <a href="{{ route('matches.list',['type'=>'pubg_duo']) }}" class="game-card">
            <span class="card-tag" style="background:#fbc02d">DUO</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/pubg_duo.jpeg') }}')"></div>
            <div class="info">
                <p class="title">DUO MATCH</p>
                <p class="count">{{ $gameCounts['pubg_duo'] ?? 0 }} Matches</p>
            </div>
        </a>
        <a href="{{ route('matches.list',['type'=>'pubg_squad']) }}" class="game-card">
            <span class="card-tag" style="background:#fbc02d">SQUAD</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/pubg_squad.jpeg') }}')"></div>
            <div class="info">
                <p class="title">SQUAD MATCH</p>
                <p class="count">{{ $gameCounts['pubg_squad'] ?? 0 }} Matches</p>
            </div>
        </a>
        <a href="{{ route('matches.list',['type'=>'pubg_arena']) }}" class="game-card">
            <span class="card-tag" style="background:#fbc02d">TDM</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/pubg_arena.jpeg') }}')"></div>
            <div class="info">
                <p class="title">ARENA MATCH</p>
                <p class="count">{{ $gameCounts['pubg_arena'] ?? 0 }} Matches</p>
            </div>
        </a>
    </div>

    <h2 class="section-header" style="color: #ff00ff;"><i class="fas fa-plus-circle"></i> EXTRA GAMES</h2>
    <div class="match-grid">
        <a href="{{ route('matches.list',['type'=>'ludo']) }}" class="game-card">
            <span class="card-tag" style="background:#ff00ff">CLASSIC</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/ludo.jpeg') }}')"></div>
            <div class="info">
                <p class="title">LUDO KING</p>
                <p class="count">{{ $gameCounts['ludo'] }} Matches</p>
            </div>
        </a>
        <a href="{{ route('matches.list',['type'=>'cs_2v2']) }}" class="game-card">
            <span class="card-tag" style="background:#ff00ff">DUO CS</span>
            <div class="banner" style="background-image:url('{{ asset('assets/images/cs_2v2_banner.jpg') }}')"></div>
            <div class="info">
                <p class="title">CS 2 VS 2</p>
                <p class="count">{{ $gameCounts['cs_2v2'] }} Matches</p>
            </div>
        </a>
    </div>

    <h2 class="section-header"><i class="fas fa-broadcast-tower"></i> LIVE STREAMING</h2>
    <div class="video-container">
        <div class="video-wrapper">
            <iframe src="https://www.youtube.com/embed/k93YJqCh_5E?autoplay=1&mute=1&controls=1&rel=0" allowfullscreen></iframe>
        </div>
    </div>

</div>

<a href="{{ $supportLink }}" class="fab"><i class="fab fa-whatsapp"></i></a>

@include('partials.bottom-nav')

<script>
document.addEventListener('DOMContentLoaded',()=>{
    const vp=document.getElementById('viewPager');
    if(!vp)return;
    const slides=vp.children;
    const dots=document.getElementById('dotsContainer');
    let i=0;
    
    [...slides].forEach((_,x)=>{
        const d=document.createElement('div');
        d.className='dot'+(x==0?' active':'');
        d.onclick=()=>{i=x;u()};
        dots.appendChild(d);
    });

    function u(){
        vp.style.transform=`translateX(-${i*100}%)`;
        [...dots.children].forEach((d,x)=>d.classList.toggle('active',x==i));
    }

    setInterval(()=>{
        i=(i+1)%slides.length;
        u();
    },4000);
});
</script>

</body>
</html>