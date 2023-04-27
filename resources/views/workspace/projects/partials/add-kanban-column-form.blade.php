<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add New Column') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Add a new column for your project's Kanban board.") }}
        </p>
    </header>

    <form method="post" action="{{ route($type . '.projects.columns.store', ['id' => $id, 'project_id' => $project->id]) }}" class="mt-6 space-y-6">
@csrf

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

@if (session('status') === 'column-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
>{{ __('Saved.') }}</p>
@endif
        </div>
    </form>
</section>
