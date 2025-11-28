<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <!-- Header with Success Color -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 20px; text-align: center;">
            <div style="font-size: 60px; margin-bottom: 10px;">🎉</div>
            <h1 style="margin: 0; font-size: 28px;">Selamat!</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Lamaran Anda Diterima</p>
        </div>

        <!-- Content -->
        <div style="padding: 40px 30px;">
            <p style="margin: 0 0 20px 0; font-size: 16px;">Halo <strong>{{ $user->name }}</strong>,</p>

            <p style="margin: 0 0 25px 0; font-size: 15px; line-height: 1.8;">
                Kami dengan senang hati memberitahukan bahwa lamaran Anda untuk posisi
                <strong style="color: #667eea;">{{ $job->title }}</strong> telah <strong style="color: #27ae60;">DITERIMA</strong>! 🎊
            </p>

            <!-- Info Box -->
            <div style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); padding: 25px; border-radius: 8px; margin: 25px 0; border-left: 5px solid #27ae60;">
                <h3 style="margin: 0 0 15px 0; color: #27ae60; font-size: 18px;">
                    <span style="font-size: 24px;">✓</span> Status: DITERIMA
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
                        <td style="padding: 8px 0; font-weight: bold;">Lokasi:</td>
                        <td style="padding: 8px 0;">{{ $job->location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">Tanggal Diterima:</td>
                        <td style="padding: 8px 0;">{{ now()->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>

            <!-- Next Steps -->
            <div style="background-color: #fff3cd; padding: 20px; border-radius: 8px; margin: 25px 0; border-left: 5px solid #ffc107;">
                <h3 style="margin: 0 0 15px 0; color: #856404; font-size: 16px;">
                    📋 Langkah Selanjutnya:
                </h3>
                <ol style="margin: 0; padding-left: 20px; color: #856404;">
                    <li style="margin-bottom: 8px;">Tim HR kami akan menghubungi Anda dalam 1-3 hari kerja</li>
                    <li style="margin-bottom: 8px;">Siapkan dokumen yang diperlukan (KTP, Ijazah, dll)</li>
                    <li style="margin-bottom: 8px;">Pastikan nomor telepon dan email Anda aktif</li>
                </ol>
            </div>

            <p style="margin: 25px 0; font-size: 15px; line-height: 1.8;">
                Terima kasih atas minat dan kepercayaan Anda untuk bergabung dengan kami.
                Kami sangat menantikan untuk bekerja sama dengan Anda!
            </p>

            <p style="margin: 30px 0 10px 0; font-size: 15px;">Salam Hangat,</p>
            <p style="margin: 0; font-size: 15px;"><strong>Tim Rekrutmen</strong></p>
            <p style="margin: 5px 0 0 0; font-size: 14px; color: #666;">{{ config('app.name') }}</p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8f9fa; padding: 25px; text-align: center; border-top: 1px solid #e9ecef;">
            <p style="margin: 0 0 10px 0; color: #6c757d; font-size: 13px;">
                Jika ada pertanyaan, silakan hubungi kami di:
            </p>
            <p style="margin: 0; color: #6c757d; font-size: 13px;">
                📧 recruitment@company.com | 📞 (021) 1234-5678
            </p>
            <p style="margin: 15px 0 0 0; color: #adb5bd; font-size: 12px;">
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
