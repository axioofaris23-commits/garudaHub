<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Proyek</h2>
            @if (auth()->user()->role === 'client')
                <a href="{{ route('projects.create') }}"
                   class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md">+ Pasang Proyek</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('projects.index') }}" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul proyek..."
                       class="flex-1 border-gray-300 rounded-md shadow-sm">
                <button class="px-4 py-2 bg-gray-800 text-white rounded-md">Cari</button>
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg divide-y">
                @forelse ($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="block p-4 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-900">{{ $project->title }}</span>
                            <span class="text-sm px-2 py-0.5 rounded bg-gray-100">{{ $project->status }}</span>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">
                            {{ $project->category }} ·
                            Budget Rp {{ number_format($project->budget, 0, ',', '.') }} ·
                            {{ $project->bids_count }} penawaran ·
                            oleh {{ $project->client->name }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Batas: {{ $project->bid_deadline->format('d M Y H:i') }}
                        </div>
                    </a>
                @empty
                    <p class="p-4 text-gray-500">Belum ada proyek.</p>
                @endforelse
            </div>

            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>