<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Proyek</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('projects.update', $project) }}"
                  class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')
                @include('projects._form', ['project' => $project])
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded-md">Perbarui</button>
                    <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 border rounded-md">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>