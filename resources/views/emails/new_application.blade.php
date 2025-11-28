@component('mail::message')
# 🔔 Lamaran Baru Diterima

Halo Admin!

Ada lamaran baru yang masuk untuk posisi **{{ $application->job->title }}**

## Detail Pelamar:
- **Nama:** {{ $application->user->name }}
- **Email:** {{ $application->user->email }}
- **Tanggal Melamar:** {{ $application->created_at->format('d F Y, H:i') }} WIB

@component('mail::button', ['url' => $cvUrl, 'color' => 'primary'])
📄 Download CV
@endcomponent

@component('mail::button', ['url' => $applicationsUrl, 'color' => 'success'])
👀 Lihat Semua Lamaran
@endcomponent

Silakan review lamaran ini segera.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
