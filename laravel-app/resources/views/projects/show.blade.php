<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $project->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-600 mb-3">
                    {{ $project->category }} · Status: {{ $project->status }} ·
                    Budget Rp {{ number_format($project->budget, 0, ',', '.') }} ·
                    Batas {{ $project->bid_deadline->format('d M Y H:i') }} ·
                    oleh {{ $project->client->name }}
                </div>
                <p class="text-gray-800 whitespace-pre-line">{{ $project->description }}</p>

                @if (auth()->id() === $project->client_id)
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('projects.edit', $project) }}" class="px-3 py-1.5 border rounded-md text-sm">Edit</a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}"
                              onsubmit="return confirm('Hapus proyek ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-600 text-white rounded-md text-sm">Hapus</button>
                        </form>
                    </div>
                @endif
            </div>

            @if (auth()->user()->role === 'developer' && $project->status === 'open')
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-3">Ajukan Penawaran</h3>
                    <form method="POST" action="{{ route('bids.store', $project) }}" class="space-y-3">
                        @csrf
                        <div>
                            <x-input-label for="price" value="Harga (Rp)" />
                            <x-text-input id="price" name="price" type="number" min="1"
                                          class="block mt-1 w-full" :value="old('price')" required />
                        </div>
                        <div>
                            <x-input-label for="duration_days" value="Durasi (hari)" />
                            <x-text-input id="duration_days" name="duration_days" type="number" min="1"
                                          class="block mt-1 w-full" :value="old('duration_days')" required />
                        </div>
                        <div>
                            <x-input-label for="proposal" value="Proposal" />
                            <textarea id="proposal" name="proposal" rows="4" required
                                      class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('proposal') }}</textarea>
                        </div>
                        <button class="px-4 py-2 bg-gray-800 text-white rounded-md">Kirim Penawaran</button>
                    </form>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-3">Penawaran ({{ $project->bids->count() }})</h3>
                @forelse ($project->bids as $bid)
                    <div class="border-t py-3">
                        <div class="font-medium">
                            {{ $bid->developer->name }} ·
                            Rp {{ number_format($bid->price, 0, ',', '.') }} ·
                            {{ $bid->duration_days }} hari ·
                            <span class="text-sm">{{ $bid->status }}</span>
                        </div>
                        <p class="text-sm text-gray-600 whitespace-pre-line">{{ $bid->proposal }}</p>

                        @if (auth()->id() === $project->client_id && $project->status === 'open')
                            <form method="POST" action="{{ route('bids.accept', $bid) }}" class="mt-2"
                                  onsubmit="return confirm('Pilih penawaran ini sebagai pemenang?')">
                                @csrf
                                <button class="px-3 py-1.5 bg-green-600 text-white rounded-md text-sm">Pilih pemenang</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada penawaran.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>