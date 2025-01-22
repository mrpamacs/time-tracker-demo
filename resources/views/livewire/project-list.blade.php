<div class="flex flex-col gap-4 justify-items-center">
    <div class="flex flex-col text-xl justify-center py-4 font-bold items-center">Track Time for Project</div>
    <div class="mb-4">
        <input
                type="text"
                wire:model.defer="newProjectName"
                wire:keydown.enter="createProject"
                placeholder="Add new project"
                class="border p-2 rounded w-full"
        />
        <x-input-error :messages="$errors->get('newProjectName')" class="mt-2" />
    </div>

    @foreach ($projects as $project)
    <x-mary-list-item :item="$project">
        <x-slot:value>
            <a href="#" wire:click.prevent="$dispatch('openTacker', {projectId: {{ $project->id }} })" class="text-gray-500 flex flex-col text-xl px-2 py-4 items-center capitalize">
                {{ $project->name }}
            </a>
        </x-slot:value>
    </x-mary-list-item>
    @endforeach
    <livewire:time-tracker />
</div>