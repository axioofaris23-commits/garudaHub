<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pasang Proyek Baru</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('projects.store') }}"
                  class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                @csrf
                @include('projects._form', ['project' => null])
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded-md">Simpan</button>
                    <a href="{{ route('projects.index') }}" class="px-4 py-2 border rounded-md">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>