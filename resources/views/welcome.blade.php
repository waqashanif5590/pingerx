<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PingerX | Real-Time Chat</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #111827;
        }

        a {
            text-decoration: none;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        /* ---------------- Header ---------------- */

        header {
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 30px;
            font-weight: 700;
            color: #2563eb;
        }

        nav {
            display: flex;
            gap: 15px;
        }

        /* ---------------- Buttons ---------------- */

        .btn {
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-login {
            border: 2px solid #2563eb;
            color: #2563eb;
        }

        .btn-login:hover {
            background: #2563eb;
            color: white;
        }

        .btn-register {
            background: #2563eb;
            color: white;
        }

        .btn-register:hover {
            background: #1d4ed8;
        }

        /* ---------------- Hero ---------------- */

        .hero {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 70px;
        }

        .hero-content {
            flex: 1;
        }

        .hero-content h1 {
            font-size: 56px;
            line-height: 1.2;
            margin-bottom: 25px;
        }

        .hero-content p {
            font-size: 18px;
            color: #6b7280;
            line-height: 1.8;
            max-width: 560px;
            margin-bottom: 35px;
        }

        /* ---------------- Features ---------------- */

        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-bottom: 40px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 17px;
            font-weight: 500;
        }

        .feature span {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* ---------------- CTA ---------------- */

        .cta {
            display: flex;
            gap: 18px;
        }

        /* ---------------- Illustration ---------------- */

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .phone {
            width: 360px;
            background: white;
            border-radius: 30px;
            padding: 25px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .12);
        }

        .chat {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .bubble {
            padding: 14px 18px;
            border-radius: 18px;
            width: 75%;
            font-size: 15px;
            line-height: 1.5;
        }

        .received {
            background: #f3f4f6;
            align-self: flex-start;
        }

        .sent {
            background: #2563eb;
            color: white;
            align-self: flex-end;
        }

        /* ---------------- Footer ---------------- */

        footer {
            padding: 30px 0;
            text-align: center;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }

        /* ---------------- Responsive ---------------- */

        @media(max-width:900px) {

            .hero {
                flex-direction: column;
                text-align: center;
                padding: 60px 0;
            }

            .hero-content p {
                margin: auto auto 35px;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .cta {
                justify-content: center;
            }

            .hero-content h1 {
                font-size: 42px;
            }

            .phone {
                width: 100%;
                max-width: 360px;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        <header>

            <div class="logo">
                <x-application-logo />
            </div>

            <nav>

                <a href="{{ route('login') }}" class="btn btn-login">
                    Login
                </a>

                <a href="{{ route('register') }}" class="btn btn-register">
                    Register
                </a>

            </nav>

        </header>

        <section class="hero">

            <div class="hero-content">

                <h1>
                    Real-Time Conversations,<br>
                    Simplified.
                </h1>

                <p>
                    Stay connected with friends, family, and teams through secure,
                    fast, and reliable messaging. Built for seamless communication
                    anytime, anywhere.
                </p>

                <div class="features">

                    <div class="feature">
                        <span>✓</span>
                        Real-time Messaging
                    </div>

                    <div class="feature">
                        <span>✓</span>
                        Online Presence
                    </div>

                    <div class="feature">
                        <span>✓</span>
                        Read Receipts
                    </div>

                    <div class="feature">
                        <span>✓</span>
                        Instant Notifications
                    </div>

                </div>

                <div class="cta">

                    <a href="{{ route('login') }}" class="btn btn-register">
                        Get Started
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-login">
                        Create Account
                    </a>

                </div>

            </div>

            <div class="hero-image">

                <div class="phone">

                    <div class="chat">

                        <div class="bubble received">
                            👋 Hi! Welcome to PingerX.
                        </div>

                        <div class="bubble sent">
                            Thanks! Looks clean and fast.
                        </div>

                        <div class="bubble received">
                            Start chatting with your friends instantly.
                        </div>

                        <div class="bubble sent">
                            🚀 Let's go!
                        </div>

                    </div>

                </div>

            </div>

        </section>

        <footer>

            © 2026 PingerX • Secure • Fast • Reliable

        </footer>

    </div>

</body>

</html>