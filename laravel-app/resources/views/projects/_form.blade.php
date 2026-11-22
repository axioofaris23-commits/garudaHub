<div>
    <x-input-label for="title" value="Judul" />
    <x-text-input id="title" name="title" class="block mt-1 w-full"
                  :value="old('title', $project->title ?? '')" required />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div>
    <x-input-label for="description" value="Deskripsi" />
    <textarea id="description" name="description" rows="5" required
              class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $project->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div>
    <x-input-label for="category" value="Kategori" />
    <x-text-input id="category" name="category" class="block mt-1 w-full"
                  :value="old('category', $project->category ?? '')" required />
    <x-input-error :messages="$errors->get('category')" class="mt-2" />
</div>

<div>
    <x-input-label for="budget" value="Budget (Rp)" />
    <x-text-input id="budget" name="budget" type="number" min="1" class="block mt-1 w-full"
                  :value="old('budget', $project->budget ?? '')" required />
    <x-input-error :messages="$errors->get('budget')" class="mt-2" />
</div>

<div>
    <x-input-label for="bid_deadline" value="Batas Lelang" />
    <x-text-input id="bid_deadline" name="bid_deadline" type="datetime-local" class="block mt-1 w-full"
                  :value="old('bid_deadline', isset($project) ? $project->bid_deadline->format('Y-m-d\TH:i') : '')" required />
    <x-input-error :messages="$errors->get('bid_deadline')" class="mt-2" />
</div>