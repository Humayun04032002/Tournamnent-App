<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core Developer - OX FF TOUR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;900&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #00f2fe;
            --secondary: #7000ff;
            --bg: #020308;
        }

        body, html {
            margin: 0; padding: 0; width: 100%; height: 100%;
            background-color: var(--bg);
            color: #fff; font-family: 'Rajdhani', sans-serif;
            overflow-x: hidden;
        }

        /* Lightning Canvas Background */
        #canvas {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1; pointer-events: none;
        }

        .dev-wrapper {
            min-height: 100vh;
            display: flex; justify-content: center; align-items: center;
            padding: 20px;
        }

        .dev-card {
            max-width: 400px; width: 100%;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 242, 254, 0.2);
            border-radius: 30px;
            padding: 40px 20px;
            text-align: center;
            position: relative;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Glowing Profile Image with Dual Rings */
        .avatar-container {
            position: relative; width: 140px; height: 140px; margin: 0 auto 25px;
        }
        .avatar-container img {
            width: 100px; height: 100px; border-radius: 50%;
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            z-index: 5; object-fit: cover;
            border: 2px solid var(--bg);
        }
        .avatar-container::before, .avatar-container::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            border-radius: 50%; border: 3px solid transparent;
        }
        .avatar-container::before {
            border-top-color: var(--primary); border-bottom-color: var(--primary);
            animation: spin 2s linear infinite;
        }
        .avatar-container::after {
            border-left-color: var(--secondary); border-right-color: var(--secondary);
            margin: -6px; animation: spinBack 4s linear infinite;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        @keyframes spinBack { 100% { transform: rotate(-360deg); } }

        /* Name Shine Effect */
        .dev-name {
            font-family: 'Orbitron'; font-weight: 900; font-size: 1.8rem;
            background: linear-gradient(90deg, #fff, var(--primary), #fff);
            background-size: 200% auto;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin: 10px 0; text-transform: uppercase;
            animation: shineText 3s linear infinite;
        }
        @keyframes shineText { to { background-position: 200% center; } }

        .dev-tag {
            color: var(--primary); font-size: 0.9rem; font-weight: bold;
            letter-spacing: 4px; margin-bottom: 30px; display: block;
        }

        /* Glass Info Tiles */
        .info-tile {
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 12px; padding: 15px;
            border-radius: 15px; display: flex; align-items: center; gap: 15px;
            border-left: 3px solid var(--primary);
            transition: 0.3s; text-align: left;
        }
        .info-tile i { color: var(--primary); font-size: 1.2rem; }
        .info-tile div h6 { margin: 0; color: #888; font-size: 0.7rem; text-transform: uppercase; }
        .info-tile div p { margin: 0; font-weight: bold; font-size: 0.9rem; }

        /* Social Buttons */
        .social-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 25px; }
        .btn {
            padding: 12px; border-radius: 12px; text-decoration: none; color: #fff;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            font-weight: bold; font-size: 0.9rem; transition: 0.3s;
        }
        .btn-fb { background: #1877F2; box-shadow: 0 0 15px rgba(24, 119, 242, 0.3); }
        .btn-wa { background: #25D366; box-shadow: 0 0 15px rgba(37, 211, 102, 0.3); }

        .exit-btn {
            margin-top: 30px; display: inline-block; color: #555;
            text-decoration: none; font-family: 'Orbitron'; font-size: 0.7rem;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <canvas id="canvas"></canvas>

    <div class="dev-wrapper">
        <div class="dev-card">
            <div class="avatar-container">
                <img src="https://scontent.fdac147-1.fna.fbcdn.net/v/t39.30808-1/602974771_2305597353199961_4989426711533219783_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=107&ccb=1-7&_nc_sid=e99d92&_nc_eui2=AeGFcp_bvCjkTU7iznJrzi-qjU-KRkMWj3CNT4pGQxaPcB3yakORzcm0l9MOAXFvBv7nW-YzLXeXJ4ZbbqADFuDA&_nc_ohc=SBOPNTA9GPMQ7kNvwG7HqAL&_nc_oc=AdmMyRegnq51M_f4AlhT2IoFdOXkyi88Nia3p478xtRDOnkROtqpKD5AqgvXQVpoGVQ&_nc_zt=24&_nc_ht=scontent.fdac147-1.fna&_nc_gid=qm9cEKOKVG3LouKYyJFoxA&oh=00_Afop2j0RsrPeD5122UG1MhZDueTGpDuPdsthB3CcubOAUg&oe=69618864" alt="Nazmul">
            </div>

            <h2 class="dev-name">Humayun Ahmed</h2>
            <span class="dev-tag">CORE DEVELOPER</span>

            <div class="info-tile">
                <i class="fas fa-code"></i>
                <div>
                    <h6>Expertise</h6>
                    <p>Laravel & Android Dev</p>
                </div>
            </div>

            <div class="info-tile">
                <i class="fas fa-bolt"></i>
                <div>
                    <h6>Experience</h6>
                    <p>UI/UX & Secure Systems</p>
                </div>
            </div>

            <div class="social-row">
                <a href="https://www.facebook.com/Huumayuun" class="btn btn-fb"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="https://wa.me/8801768802953" class="btn btn-wa">
    <i class="fab fa-whatsapp"></i> WhatsApp
</a>
            </div>

            <a href="javascript:history.back()" class="exit-btn">
                <i class="fas fa-power-off"></i> EXIT INTERFACE
            </a>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        let width, height;

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        function createLightning() {
            const x = Math.random() * width;
            ctx.beginPath();
            ctx.strokeStyle = '#00f2fe';
            ctx.lineWidth = 2;
            ctx.shadowBlur = 15;
            ctx.shadowColor = '#00f2fe';
            ctx.moveTo(x, 0);
            let currX = x;
            let currY = 0;
            for(let i=0; i<10; i++) {
                currX += (Math.random() - 0.5) * 40;
                currY += (Math.random() * height / 10);
                ctx.lineTo(currX, currY);
            }
            ctx.stroke();
        }

        function loop() {
            ctx.fillStyle = 'rgba(2, 3, 8, 0.15)';
            ctx.fillRect(0, 0, width, height);
            if (Math.random() > 0.96) {
                createLightning();
            }
            requestAnimationFrame(loop);
        }
        loop();
    </script>
</body>
</html>