<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Forgot Password - OX FF TOUR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;800&family=Rajdhani:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #a855f7;
            --secondary: #22d3ee;
            --error-glow: #ff3131;
            --bg-dark: #05060f;
        }

        body {
            margin: 0; padding: 0;
            display: flex; justify-content: center; align-items: center;
            height: 100vh;
            background: var(--bg-dark);
            font-family: 'Rajdhani', sans-serif;
            color: #fff;
            overflow: hidden;
        }

        /* Background Glow Effect */
        .bg-glow {
            position: fixed; width: 350px; height: 350px;
            background: var(--primary); filter: blur(130px);
            opacity: 0.15; z-index: -1;
        }

        .main-container {
            width: 90%; max-width: 400px;
            position: relative;
        }

        /* --- Snake Glow Wrapper --- */
        .form-wrapper {
            position: relative;
            background: rgba(15, 18, 43, 0.95);
            padding: 40px 25px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
            text-align: center;
        }

        /* Rotating Snake Border */
        .form-wrapper::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: conic-gradient(
                transparent, 
                var(--secondary), 
                var(--primary), 
                transparent 40%
            );
            animation: rotateBorder 3s linear infinite;
            z-index: -2;
        }

        .form-wrapper::after {
            content: '';
            position: absolute;
            inset: 3px;
            background: #0d1121;
            border-radius: 18px;
            z-index: -1;
        }

        @keyframes rotateBorder {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .form-header h2 {
            margin: 0; font-family: 'Orbitron', sans-serif;
            font-size: 1.4rem; color: var(--secondary);
            letter-spacing: 2px;
            text-shadow: 0 0 15px rgba(34, 211, 238, 0.4);
        }

        .form-header p {
            font-size: 14px; color: #aaa; margin: 10px 0 25px;
        }

        /* Input Styling */
        .input-group { position: relative; margin-bottom: 20px; }
        .input-group i {
            position: absolute; left: 15px; top: 50%;
            transform: translateY(-50%); color: var(--secondary);
            font-size: 14px;
        }

        .input-field {
            width: 100%; padding: 14px 15px 14px 45px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px; color: #fff;
            box-sizing: border-box; outline: none; transition: 0.3s;
            font-size: 15px;
        }

        .input-field:focus {
            border-color: var(--secondary);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 10px rgba(34, 211, 238, 0.2);
        }

        /* Button Styling */
        .btn {
            width: 100%; padding: 15px; border: none;
            border-radius: 12px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white; font-family: 'Orbitron'; font-weight: bold;
            cursor: pointer; text-transform: uppercase; font-size: 14px;
            letter-spacing: 1px;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.4);
            transition: 0.3s;
        }

        .btn:active { transform: scale(0.98); }

        /* Messages */
        .success-msg {
            background: rgba(34, 211, 238, 0.1); color: var(--secondary);
            padding: 12px; border-radius: 10px; margin-bottom: 20px;
            font-size: 13px; border: 1px solid var(--secondary);
        }

        .error-msg {
            background: rgba(255, 49, 49, 0.1); color: #ff9999;
            padding: 12px; border-radius: 10px; margin-bottom: 20px;
            font-size: 13px; border: 1px solid var(--error-glow);
        }

        .back-link {
            display: block; margin-top: 25px; color: #888;
            text-decoration: none; font-size: 14px; font-weight: 600;
            transition: 0.3s;
        }

        .back-link:hover { color: var(--secondary); }
    </style>
</head>
<body>

    <div class="bg-glow" style="top: -100px; right: -100px;"></div>

    <div class="main-container">
        <div class="form-wrapper">
            <div class="form-header">
                <h2>RECOVER ACCESS</h2>
                <p>Enter your email to receive a reset link</p>
            </div>

            {{-- Success message --}}
            @if(session('status'))
                <div class="success-msg">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            {{-- Error messages --}}
            @if ($errors->any())
                <div class="error-msg">
                    @foreach ($errors->all() as $error)
                        <div><i class="fas fa-exclamation-triangle"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="input-field" placeholder="Email Address" value="{{ old('email') }}" required>
                </div>
                
                <button type="submit" class="btn">SEND RESET LINK</button>
            </form>

            <a href="{{ route('login') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>

</body>
</html>