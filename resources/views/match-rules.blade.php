<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>{{ $match->Match_Title }} - Rules</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #00f2fe;
            --accent: #ff007a;
            --bg-dark: #0a0b1e;
            --glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at top right, #1a1b3a, #0a0b1e);
            color: #fff;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        /* --- Custom Header --- */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .back-btn {
            width: 40px; height: 40px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
        }

        .header h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.1rem;
            margin: 0;
            color: var(--secondary);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* --- Rules Container --- */
        .rules-box {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .rules-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .rules-icon-top {
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 80px;
            color: rgba(255, 255, 255, 0.03);
            transform: rotate(-15deg);
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.05rem;
            color: #e0e0e0;
            margin: 0;
            text-align: justify;
        }

        /* --- Highlight Section --- */
        .warning-footer {
            margin-top: 20px;
            background: rgba(255, 0, 122, 0.1);
            border-left: 4px solid var(--accent);
            padding: 15px;
            border-radius: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ff80b3;
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="javascript:history.back()" class="back-btn">
            <i class="fas fa-chevron-left"></i>
        </a>
        <h2>Protocol & Rules</h2>
    </div>

    <div class="rules-box">
        <i class="fas fa-scroll rules-icon-top"></i>
        <pre>{{ $rulesText }}</pre>
    </div>

    <div class="warning-footer">
        <i class="fas fa-exclamation-triangle"></i>
        <span>হ্যাকিং বা কোনো প্রকার আনফেয়ার গেমপ্লে ধরা পড়লে অ্যাকাউন্ট পার্মানেন্টলি ব্যান করা হবে।</span>
    </div>

    <div class="footer-note">
        OX FF TOUR - Fair Play Only
    </div>

</body>
</html>