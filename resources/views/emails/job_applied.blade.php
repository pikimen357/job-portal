<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 20px 0;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #45a049;
        }
        .info-box {
            background-color: #f0f0f0;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lamaran Berhasil Dikirim!</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>

            <p>Terima kasih telah melamar untuk posisi <strong>{{ $job->title }}</strong>.</p>

            <div class="info-box">
                <h3 style="margin-top: 0;">Detail Lamaran:</h3>
                <p style="margin: 5px 0;"><strong>Posisi:</strong> {{ $job->title }}</p>
                <p style="margin: 5px 0;"><strong>Perusahaan:</strong> {{ $job->company ?? 'PT Example' }}</p>
                <p style="margin: 5px 0;"><strong>Tanggal Melamar:</strong> {{ now()->format('d F Y, H:i') }}</p>
            </div>

            <p>Lamaran Anda telah kami terima dan sedang dalam proses review.</p>

            @if($cvUrl)
                <p>Anda dapat mengunduh CV yang telah Anda kirimkan dengan klik tombol di bawah ini:</p>

                <div style="text-align: center;">
                    <a href="{{ $cvUrl }}" class="button" target="_blank">
                        📄 Download CV Anda
                    </a>
                </div>
            @endif

            <p>Tim kami akan menghubungi Anda jika profil Anda sesuai dengan kualifikasi yang kami cari.</p>

            <p style="margin-top: 30px;">Salam Hangat,<br>
            <strong>Tim Rekrutmen</strong></p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
