<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Posts | PingerX</title>

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

    .container {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .card {
      width: 100%;
      max-width: 650px;
      background: #fff;
      border-radius: 18px;
      padding: 50px;
      text-align: center;
      border: 1px solid #e5e7eb;
      box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
    }

    .icon {
      width: 90px;
      height: 90px;
      margin: 0 auto 25px;
      border-radius: 50%;
      background: #dbeafe;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 42px;
    }

    h1 {
      font-size: 34px;
      margin-bottom: 18px;
      color: #111827;
    }

    p {
      font-size: 17px;
      line-height: 1.8;
      color: #6b7280;
      margin-bottom: 35px;
    }

    .features {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin-bottom: 40px;
      text-align: left;
    }

    .feature {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 15px;
      color: #374151;
    }

    .feature span {
      color: #2563eb;
      font-weight: bold;
      font-size: 18px;
    }

    .btn {
      display: inline-block;
      padding: 14px 32px;
      background: #2563eb;
      color: #fff;
      text-decoration: none;
      border-radius: 10px;
      font-weight: 600;
      transition: .25s;
    }

    .btn:hover {
      background: #1d4ed8;
    }

    @media(max-width:700px) {

      .card {
        padding: 35px 25px;
      }

      .features {
        grid-template-columns: 1fr;
      }

      h1 {
        font-size: 28px;
      }

      p {
        font-size: 16px;
      }

    }
  </style>

</head>

<body>

  <div class="container">

    <div class="card">

      <div class="icon">
        📢
      </div>

      <h1>Posts Coming Soon</h1>

      <p>
        We're currently developing the Posts feature for PingerX.
        Soon you'll be able to share updates, photos, and moments with your friends.
      </p>

      <div class="features">

        <div class="feature">
          <span>✓</span>
          Share Photos
        </div>

        <div class="feature">
          <span>✓</span>
          Create Posts
        </div>

        <div class="feature">
          <span>✓</span>
          Like & Comment
        </div>

        <div class="feature">
          <span>✓</span>
          Engage with Friends
        </div>

      </div>

      <a href="{{ route('chat') }}" class="btn">
        Back to Chat
      </a>

    </div>

  </div>

</body>

</html>