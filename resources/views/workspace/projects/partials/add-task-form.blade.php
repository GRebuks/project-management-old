<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add New Task') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Add a new task for your project.") }}
        </p>
    </header>

    <form method="post" action="{{ route($type . '.projects.tasks.store', ['id' => $id, 'project_id' => $project->id]) }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" required autofocus autocomplete="description" />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="due_date" :value="__('Due date')" />
            <x-text-input id="due_date" class="block mt-1 w-full" type="datetime-local" name="due_date" :value="old('due_date')" required autofocus autocomplete="due_date" />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="column_id" :value="__('Column')" />
            <select name="column_id" id="column_id" class="block mt-1 w-full">
                @foreach($columns as $column)
                    <option value="{{ $column->id }}">{{ $column->title }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('column_id')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'task-created')
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
