<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 20px; text-align: center;">
            <div style="font-size: 50px; margin-bottom: 10px;">📬</div>
            <h1 style="margin: 0; font-size: 26px;">Pemberitahuan Status Lamaran</h1>
        </div>

        <!-- Content -->
        <div style="padding: 40px 30px;">
            <p style="margin: 0 0 20px 0; font-size: 16px;">Halo <strong>{{ $user->name }}</strong>,</p>

            <p style="margin: 0 0 25px 0; font-size: 15px; line-height: 1.8;">
                Terima kasih atas minat dan waktu yang Anda luangkan untuk melamar posisi
                <strong>{{ $job->title }}</strong> di perusahaan kami.
            </p>

            <!-- Info Box -->
            <div style="background-color: #f8f9fa; padding: 25px; border-radius: 8px; margin: 25px 0; border-left: 5px solid #6c757d;">
                <h3 style="margin: 0 0 15px 0; color: #495057; font-size: 18px;">
                    Detail Lamaran
                </h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; width: 140px;">Posisi:</td>
                        <td style="padding: 8px 0;">{{ $job->title }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">Perusahaan:</td>
                        <td style="padding: 8px 0;">{{ $job->company ?? 'PT Example' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">Tanggal Melamar:</td>
                        <td style="padding: 8px 0;">{{ $application->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">Status:</td>
                        <td style="padding: 8px 0; color: #dc3545; font-weight: bold;">Tidak Lolos Seleksi</td>
                    </tr>
                </table>
            </div>

            <p style="margin: 25px 0; font-size: 15px; line-height: 1.8;">
                Setelah melalui proses seleksi yang ketat, kami memutuskan untuk melanjutkan dengan kandidat lain
                yang profil dan pengalamannya lebih sesuai dengan kebutuhan posisi saat ini.
            </p>

            <!-- Encouragement Box -->
            <div style="background-color: #e3f2fd; padding: 20px; border-radius: 8px; margin: 25px 0; border-left: 5px solid #2196f3;">
                <p style="margin: 0 0 12px 0; font-size: 15px; font-weight: bold; color: #1976d2;">
                    💡 Jangan Berkecil Hati!
                </p>
                <p style="margin: 0; font-size: 14px; line-height: 1.7; color: #0d47a1;">
                    Keputusan ini tidak mengurangi apresiasi kami atas kualifikasi dan pengalaman Anda.
                    Kami mendorong Anda untuk terus melamar posisi lain yang mungkin lebih sesuai dengan profil Anda.
                </p>
            </div>

            <p style="margin: 25px 0; font-size: 15px; line-height: 1.8;">
                Kami akan menyimpan informasi Anda dalam database kami dan akan menghubungi Anda
                jika ada posisi lain yang sesuai di masa mendatang.
            </p>

            <!-- Call to Action -->
            <div style="text-align: center; margin: 35px 0;">
                <a href="{{ url('/jobs') }}"
                   style="display: inline-block; padding: 15px 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 15px;">
                    🔍 Lihat Lowongan Lainnya
                </a>
            </div>

            <p style="margin: 30px 0 10px 0; font-size: 15px;">Terima kasih dan semoga sukses untuk pencarian kerja Anda!</p>
            <p style="margin: 0; font-size: 15px;"><strong>Tim Rekrutmen</strong></p>
            <p style="margin: 5px 0 0 0; font-size: 14px; color: #666;">{{ config('app.name') }}</p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8f9fa; padding: 25px; text-align: center; border-top: 1px solid #e9ecef;">
            <p style="margin: 0 0 10px 0; color: #6c757d; font-size: 13px;">
                Tetap terhubung dengan kami:
            </p>
            <p style="margin: 0; color: #6c757d; font-size: 13px;">
                🌐 www.company.com | 📧 info@company.com
            </p>
            <p style="margin: 15px 0 0 0; color: #adb5bd; font-size: 12px;">
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
