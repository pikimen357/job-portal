<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Pelamar
            </h2>
        </div>
    </header>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama Pelamar</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Lowongan</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">CV</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($applications as $app)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $app->user->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $app->job->title }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <a href="{{ asset('storage/' . $app->cv) }}" target="_blank"
                                           class="inline-flex items-center rounded-md border border-transparent bg-indigo-500 px-3 py-1 text-xs font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 mr-2">
                                            Lihat CV
                                        </a>
                                        <a href="{{ asset('storage/' . $app->cv) }}" download
                                           class="inline-flex items-center rounded-md border border-transparent bg-indigo-800 px-3 py-1 text-xs font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                            Download CV
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                            {{ $app->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' :
                                               ($app->status === 'Accepted' ? 'bg-green-100 text-green-700' :
                                               'bg-red-100 text-red-700') }}">
                                            {{ $app->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <div class="flex items-center gap-2">
                                            @if ($app->status !== 'Accepted')
                                                <form action="{{ route('applications.update', $app->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menerima pelamar ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Accepted">
                                                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-1 text-xs font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                                                        Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('applications.destroy', $app->id) }}" method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menolak pelamar ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                                        Tolak
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">
                                        Tidak ada data pelamar
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
