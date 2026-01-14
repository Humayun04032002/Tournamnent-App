<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Access - OX FF TOUR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;800&family=Rajdhani:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #a855f7; /* হালকা পার্পল */
            --secondary: #22d3ee; /* উজ্জ্বল সায়ান */
            --error-glow: #ff3131; /* উজ্জ্বল লাল */
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

        /* Background Glows */
        .bg-glow {
            position: fixed; width: 350px; height: 350px;
            background: var(--primary); filter: blur(130px);
            opacity: 0.2; z-index: -1;
        }

        .main-container {
            width: 90%; max-width: 400px;
            position: relative;
            display: flex; align-items: center; justify-content: center;
            min-height: 620px;
        }

        .form-container {
            position: absolute; width: 100%;
            transition: 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #signin-container { transform: scale(1); opacity: 1; z-index: 2; }
        #signup-container { transform: scale(0.8); opacity: 0; z-index: 1; visibility: hidden; }

        .main-container.signup-mode #signin-container { transform: scale(0.8); opacity: 0; visibility: hidden; }
        .main-container.signup-mode #signup-container { transform: scale(1); opacity: 1; z-index: 2; visibility: visible; }

        /* --- Animated Border Glow Container --- */
        .form-wrapper {
            position: relative;
            background: rgba(15, 18, 43, 0.95);
            padding: 40px 25px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
        }

        /* Light Border Gradient */
        .form-wrapper::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: conic-gradient(
                transparent, 
                var(--secondary), 
                var(--primary), 
                transparent 40% /* Lightness বাড়ানোর জন্য বাড়ানো হয়েছে */
            );
            animation: rotateBorder 3s linear infinite; /* গতি কিছুটা বাড়ানো হয়েছে */
            z-index: -2;
        }

        /* Error Border Gradient (যখন এরর থাকবে) */
        .has-error .form-wrapper::before {
            background: conic-gradient(
                transparent, 
                var(--error-glow), 
                #ff6b6b, 
                transparent 35%
            );
            animation-duration: 1s; 
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

        .form-header { text-align: center; margin-bottom: 25px; }
        .form-header h2 {
            margin: 0; font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem; color: var(--secondary);
            letter-spacing: 3px;
            text-shadow: 0 0 15px rgba(34, 211, 238, 0.5);
        }
        .has-error .form-header h2 { color: var(--error-glow); text-shadow: 0 0 15px var(--error-glow); }

        .input-group { position: relative; margin-bottom: 18px; }
        .input-group i {
            position: absolute; left: 15px; top: 50%;
            transform: translateY(-50%); color: var(--secondary);
            font-size: 14px;
        }
        .has-error .input-group i { color: var(--error-glow); }

        .input-field {
            width: 100%; padding: 14px 15px 14px 45px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px; color: #fff;
            box-sizing: border-box; outline: none; transition: 0.3s;
            font-size: 15px;
        }

        .input-field:focus { border-color: var(--secondary); background: rgba(255, 255, 255, 0.1); box-shadow: 0 0 10px rgba(34, 211, 238, 0.2); }
        .has-error .input-field:focus { border-color: var(--error-glow); }

        /* Forget Password Style */
        .forget-pass {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        .forget-pass a {
            font-size: 12px;
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }
        .forget-pass a:hover { color: var(--secondary); }

        .btn {
            width: 100%; padding: 15px; border: none;
            border-radius: 12px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white; font-family: 'Orbitron'; font-weight: bold;
            cursor: pointer; text-transform: uppercase; font-size: 14px;
            letter-spacing: 1px;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.4);
        }
        .has-error .btn { background: linear-gradient(45deg, #b91c1c, var(--error-glow)); }

        .bottom-text { text-align: center; margin-top: 25px; color: #aaa; font-size: 14px; }
        .bottom-text a { color: var(--secondary); cursor: pointer; font-weight: bold; text-decoration: none; }
        .has-error .bottom-text a { color: var(--error-glow); }

        .error-msg-box {
            background: rgba(255, 0, 51, 0.15); color: #ffd1d1;
            padding: 12px; border-radius: 10px; margin-bottom: 15px; font-size: 13px;
            border: 1px solid var(--error-glow); text-align: left;
        }
    </style>
</head>
<body>

    <div class="bg-glow" style="top: -100px; right: -100px;"></div>
    <div class="bg-glow" style="bottom: -100px; left: -100px; background: #ff007a; opacity: 0.1;"></div>

    <div class="main-container {{ $errors->any() ? 'has-error' : '' }} {{ $errors->hasBag('register') ? 'signup-mode' : '' }}" id="mainContainer">

        <div class="form-container" id="signin-container">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>{{ $errors->hasBag('login') ? 'ACCESS DENIED' : 'SIGN IN' }}</h2>
                </div>

                @if ($errors->hasBag('login'))
                    <div class="error-msg-box">
                        @foreach ($errors->login->all() as $error) <div><i class="fas fa-times-circle"></i> {{ $error }}</div> @endforeach
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="number" class="input-field" placeholder="Mobile Number" value="{{ old('number') }}" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="input-field" placeholder="Password" required>
                    </div>
                    
                    <div class="forget-pass">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn">INITIALIZE LOGIN</button>
                </form>
                <div class="bottom-text">New Hunter? <a id="show-signup">Register</a></div>
            </div>
        </div>

        <div class="form-container" id="signup-container">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>{{ $errors->hasBag('register') ? 'FAILED' : 'SIGN UP' }}</h2>
                </div>

                @if ($errors->hasBag('register'))
                    <div class="error-msg-box">
                        @foreach ($errors->register->all() as $error) <div><i class="fas fa-exclamation-triangle"></i> {{ $error }}</div> @endforeach
                    </div>
                @endif

                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    <div class="input-group"><i class="fas fa-user"></i><input type="text" name="name" class="input-field" placeholder="Full Name" value="{{ old('name') }}" required></div>
                    <div class="input-group"><i class="fas fa-envelope"></i><input type="email" name="email" class="input-field" placeholder="Email Address" value="{{ old('email') }}" required></div>
                    <div class="input-group"><i class="fas fa-mobile-alt"></i><input type="text" name="number" class="input-field" placeholder="Mobile Number" value="{{ old('number') }}" required></div>
                    <div class="input-group"><i class="fas fa-lock"></i><input type="password" name="password" class="input-field" placeholder="Create Password" required></div>
                    <button type="submit" class="btn">CREATE IDENTITY</button>
                </form>
                <div class="bottom-text">Old Member? <a id="show-signin">Login</a></div>
            </div>
        </div>

    </div>

    <script>
        const mainContainer = document.getElementById('mainContainer');
        const showSignupBtn = document.getElementById('show-signup');
        const showSigninBtn = document.getElementById('show-signin');

        showSignupBtn.addEventListener('click', () => mainContainer.classList.add('signup-mode'));
        showSigninBtn.addEventListener('click', () => mainContainer.classList.remove('signup-mode'));
    </script>
</body>
</html>