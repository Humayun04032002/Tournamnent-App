<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Refer & Earn - OX FF TOUR</title>
    
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
            color: #fff; margin: 0; padding: 20px;
            padding-bottom: 100px;
            min-height: 100vh;
        }

        /* --- Header --- */
        .header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 30px;
        }
        .back-btn {
            width: 40px; height: 40px; background: var(--glass);
            border: 1px solid var(--border); border-radius: 12px;
            color: #fff; display: flex; align-items: center; justify-content: center;
            text-decoration: none;
        }
        .header h1 {
            font-family: 'Orbitron', sans-serif; font-size: 1.1rem;
            margin: 0; color: var(--secondary); letter-spacing: 1px;
        }

        /* --- Refer Card --- */
        .refer-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            border: 1px solid var(--border);
            border-radius: 25px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            position: relative;
            overflow: hidden;
        }

        .gift-icon {
            font-size: 4rem;
            color: var(--accent);
            margin-bottom: 20px;
            filter: drop-shadow(0 0 15px var(--accent));
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .refer-card h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.3rem; margin: 0 0 10px;
            background: linear-gradient(90deg, #fff, var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .refer-card p {
            color: #b0b0b0; font-size: 0.95rem;
            line-height: 1.5; padding: 0 10px;
        }

        /* --- Referral Code Box --- */
        .referral-code-box {
            background: rgba(0,0,0,0.3);
            border: 2px dashed var(--primary);
            padding: 20px;
            border-radius: 15px;
            margin: 30px 0;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
        }
        .referral-code-box:active { transform: scale(0.95); }

        .referral-code-box span {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.8rem;
            color: var(--secondary);
            letter-spacing: 5px;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.4);
        }

        .copy-hint {
            display: block; font-size: 0.7rem; color: #666;
            text-transform: uppercase; margin-top: 8px; letter-spacing: 1px;
        }

        /* --- Share Button --- */
        .share-btn {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            border: none;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.3);
            display: flex; align-items: center; justify-content: center;
            gap: 10px; width: 100%;
            transition: 0.3s;
        }

        /* --- Reward Steps --- */
        .steps {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
            gap: 10px; margin-top: 30px;
        }
        .step-item { font-size: 0.75rem; color: #888; text-align: center; }
        .step-item i { display: block; font-size: 1.2rem; color: var(--secondary); margin-bottom: 5px; }

        /* Hidden Input for Copy */
        #hiddenInput {
            position: absolute;
            left: -9999px;
            top: 0;
        }

    </style>
</head>
<body>

    <input type="text" id="hiddenInput" value="{{ $referralCode }}">

    <div class="header">
        <a href="javascript:history.back()" class="back-btn"><i class="fas fa-chevron-left"></i></a>
        <h1>REFER & EARN</h1>
        <div style="width: 40px;"></div>
    </div>

    <div class="refer-card">
        <div class="gift-icon">
            <i class="fas fa-gift"></i>
        </div>
        
        <h2>INVITE & GET REWARD</h2>
        <p>Share your code with friends. When they join a match, you both get a bonus in your wallet!</p>
        
        <div class="referral-code-box" id="copyContainer" onclick="copyCode()">
            <span id="refCode">{{ $referralCode }}</span>
            <small class="copy-hint" id="copyHint">Tap to copy code</small>
        </div>

        <button class="share-btn" onclick="shareCode()">
            <i class="fas fa-share-nodes"></i> SHARE WITH FRIENDS
        </button>

        <div class="steps">
            <div class="step-item">
                <i class="fas fa-paper-plane"></i> Send Invite
            </div>
            <div class="step-item">
                <i class="fas fa-user-plus"></i> Friend Joins
            </div>
            <div class="step-item">
                <i class="fas fa-coins"></i> Both Earn
            </div>
        </div>
    </div>

    @include('partials.bottom-nav')

    <script>
        const referralCode = "{{ $referralCode }}";

        function copyCode() {
            const copyText = document.getElementById("hiddenInput");
            const hint = document.getElementById('copyHint');

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            try {
                // Execute copy command
                document.execCommand("copy");
                
                // Visual Feedback
                hint.innerText = "COPIED SUCCESSFULLY!";
                hint.style.color = "var(--secondary)";
                
                // Reset hint text
                setTimeout(() => {
                    hint.innerText = "Tap to copy code";
                    hint.style.color = "#666";
                }, 2000);
            } catch (err) {
                console.error('Oops, unable to copy', err);
            }
            
            // Unselect text
            window.getSelection().removeAllRanges();
        }

        function shareCode() {
            const shareText = `Join OX FF TOUR, the best Esports platform! Use my referral code: ${referralCode} and let's win together!`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'OX FF TOUR Referral',
                    text: shareText,
                    url: window.location.origin
                }).catch(console.error);
            } else {
                copyCode();
                alert('Referral text copied! Share it on WhatsApp.');
            }
        }
    </script>
</body>
</html>