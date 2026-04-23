<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication - RevAuto Bengkel</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Frameworks: Bootstrap & Bulma as requested -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #3b82f6; /* Blue 500 */
            --primary-dark: #2563eb; /* Blue 600 */
            --bg-color: #0f172a; /* Slate 900 */
            --card-bg: #1e293b; /* Slate 800 */
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            color: var(--text-main);
            position: relative;
        }

        /* Animated Grid Background */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            z-index: 1;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            transform: rotate(15deg);
            animation: gridMove 30s linear infinite;
        }

        /* Ambient Glow */
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: 
                radial-gradient(circle at 15% 50%, rgba(59, 130, 246, 0.15), transparent 40%),
                radial-gradient(circle at 85% 30%, rgba(37, 99, 235, 0.1), transparent 40%);
            animation: pulseGlow 8s ease-in-out infinite alternate;
        }

        /* Workshop Motif Animation */
        .decoration-gear {
            position: absolute;
            color: rgba(255, 255, 255, 0.05);
            z-index: 1;
            pointer-events: none;
        }

        .decoration-gear.gear-1 {
            top: 10%;
            left: 5%;
            font-size: 25rem;
            animation: spin 30s linear infinite;
        }

        .decoration-gear.gear-2 {
            bottom: -5%;
            right: 5%;
            font-size: 35rem;
            color: rgba(59, 130, 246, 0.05);
            animation: spin 45s linear infinite reverse;
        }

        .decoration-gear.wrench {
            top: 20%;
            right: 15%;
            font-size: 15rem;
            animation: floatWrench 15s ease-in-out infinite alternate;
            color: rgba(255, 255, 255, 0.04);
            transform: rotate(45deg);
        }

        @keyframes gridMove {
            0% { transform: rotate(15deg) translateY(0); }
            100% { transform: rotate(15deg) translateY(-50px); }
        }

        @keyframes pulseGlow {
            0% { opacity: 0.6; }
            100% { opacity: 1; }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes floatWrench {
            0% { transform: rotate(45deg) translateY(0); }
            100% { transform: rotate(45deg) translateY(-40px); }
        }

        /* Container for the dual sliding layout */
        .container-auth {
            background-color: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            width: 900px;
            max-width: 100%;
            min-height: 550px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 10;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        /* Form styling */
        .form-container form {
            background-color: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }
        
        .form-container h1 {
            font-weight: 800;
            margin-bottom: 25px;
            color: #fff;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }

        .form-container p.subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 25px;
        }

        /* Bootstrap/Bulma input custom overrides */
        .custom-input {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: #f8fafc !important;
            padding: 12px 15px !important;
            margin: 8px 0;
            width: 100%;
            box-shadow: none !important;
            border-radius: 8px !important;
            transition: border-color 0.3s;
        }
        .custom-input::placeholder {
            color: #475569;
        }
        .custom-input:focus {
            border-color: var(--primary) !important;
            outline: none;
        }

        .btn-auth {
            border-radius: 30px;
            border: 1px solid var(--primary);
            background-color: var(--primary);
            color: #FFFFFF;
            font-size: 0.9rem;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in, background-color 0.3s, box-shadow 0.3s;
            cursor: pointer;
            margin-top: 15px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-auth:active {
            transform: scale(0.95);
        }

        .btn-auth:focus {
            outline: none;
        }

        .btn-auth.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
            box-shadow: none;
            margin-top: 20px;
        }
        .btn-auth.ghost:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .btn-auth:not(.ghost):hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Containers positioning */
        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
            opacity: 1;
        }
        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        /* OVERLAY - Sliding door */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .overlay {
            background: linear-gradient(to right, #1e3a8a, #3b82f6);
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }
        
        .overlay::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at center, rgba(255,255,255,0.1), transparent 70%);
            z-index: 0;
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
            z-index: 1;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }
        
        .overlay-panel h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        /* --- ACTIVE STATE --- */
        .container-auth.right-panel-active .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
            z-index: 1;
        }

        .container-auth.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        .container-auth.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .container-auth.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .container-auth.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .container-auth.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        @keyframes show {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            text-align: left;
            width: 100%;
            margin-top: -5px;
            margin-bottom: 5px;
            padding-left: 5px;
        }
        
        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
            color: #fca5a5;
            padding: 10px 15px;
            font-size: 0.85rem;
            width: 100%;
            margin-bottom: 15px;
            text-align: left;
            border-radius: 0 4px 4px 0;
        }

        /* Return home link */
        .back-home {
            position: absolute;
            top: 30px;
            left: 30px;
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.3s;
            z-index: 1000;
        }
        .back-home:hover {
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Animated Workshop Motif Elements -->
    <div class="decoration-gear gear-1"><i class="fa-solid fa-gear"></i></div>
    <div class="decoration-gear gear-2"><i class="fa-solid fa-gear"></i></div>
    <div class="decoration-gear wrench"><i class="fa-solid fa-wrench"></i></div>

    <a href="{{ url('/') }}" class="back-home">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>

    <!-- Container gets 'right-panel-active' if route is REGISTER or register errors exist -->
    <div class="container-auth {{ (request()->routeIs('register') || $errors->has('name') || ($errors->has('email') && old('name'))) ? 'right-panel-active' : '' }}" id="container">
        
        <!-- Registration Form (Right Side Default) -->
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Create Account</h1>
                <p class="subtitle">Gabung dengan RevAuto hari ini.</p>
                
                @if($errors->has('name') || ($errors->has('email') && old('name')))
                    <div class="alert-error">
                        Terdapat kesalahan pada input registrasi Anda.
                    </div>
                @endif

                <input type="text" name="name" class="custom-input form-control" placeholder="Full Name" value="{{ old('name') }}" required autofocus />
                @error('name')<div class="error-message">{{ $message }}</div>@enderror

                <input type="email" name="email" class="custom-input form-control" placeholder="Email Address" value="{{ old('email') }}" required />
                @error('email')
                    @if(old('name')) <div class="error-message">{{ $message }}</div> @endif
                @enderror

                <input type="password" name="password" class="custom-input form-control" placeholder="Password" required />
                @error('password')<div class="error-message">{{ $message }}</div>@enderror

                <input type="password" name="password_confirmation" class="custom-input form-control" placeholder="Confirm Password" required />
                
                <button type="submit" class="btn-auth">Register</button>
            </form>
        </div>

        <!-- Login Form (Left Side Default - Hidden under overlay) -->
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Sign in</h1>
                <p class="subtitle">Masuk ke akun RevAuto Anda.</p>

                @if($errors->has('email') && !old('name'))
                    <div class="alert-error">
                        Kredensial yang diberikan tidak cocok dengan data kami.
                    </div>
                @endif

                <input type="email" name="email" class="custom-input form-control" placeholder="Email" value="{{ old('email') }}" required />
                @error('email')
                    @if(!old('name')) <div class="error-message">{{ $message }}</div> @endif
                @enderror

                <input type="password" name="password" class="custom-input form-control" placeholder="Password" required />
                @error('password')<div class="error-message">{{ $message }}</div>@enderror

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: #94a3b8; font-size: 0.8rem; margin-top: 10px; margin-bottom: 5px; text-decoration: none;">Forgot your password?</a>
                @endif

                <button type="submit" class="btn-auth">Sign In</button>
            </form>
        </div>

        <!-- Overlay Sliding Door -->
        <div class="overlay-container">
            <div class="overlay">
                <!-- Overlay Left Side (Welcomes, pushes to Login) -->
                <div class="overlay-panel overlay-left">
                    <div class="mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto backdrop-blur-md border border-white/30">
                            <i class="fa-solid fa-wrench text-2xl"></i>
                        </div>
                    </div>
                    <h1>Selamat Datang!</h1>
                    <p style="font-size: 0.95rem; margin-bottom: 10px; color: #e2e8f0; line-height: 1.6;">Sudah memiliki akun RevAuto?<br>Silakan masuk untuk mengakses dasbor servis Anda.</p>
                    <button class="btn-auth ghost" id="signInBtn">Sign In</button>
                </div>

                <!-- Overlay Right Side (Urges, pushes to Register) -->
                <div class="overlay-panel overlay-right">
                    <div class="mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto backdrop-blur-md border border-white/30">
                            <i class="fa-solid fa-car-side text-2xl"></i>
                        </div>
                    </div>
                    <h1>Halo, Kawan!</h1>
                    <p style="font-size: 0.95rem; margin-bottom: 10px; color: #e2e8f0; line-height: 1.6;">Belum memiliki akun? <br>Daftarkan diri Anda dan nikmati pelayanan eksklusif kami.</p>
                    <button class="btn-auth ghost" id="signUpBtn">Register</button>
                </div>
            </div>
        </div>
        
    </div>

    <!-- JS for Animation -->
    <script>
        const signUpButton = document.getElementById('signUpBtn');
        const signInButton = document.getElementById('signInBtn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
            window.history.pushState({}, '', '{{ url("/register") }}');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
            window.history.pushState({}, '', '{{ url("/login") }}');
        });
    </script>
</body>
</html>
