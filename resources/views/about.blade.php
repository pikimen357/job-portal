<h1>Selamat datang {{ $user->name }}</h1>
<p>Aplikasi ini akan membantu anda mencari dan melamar
pekerjaan.</p>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
