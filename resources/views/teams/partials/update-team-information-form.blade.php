<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Team Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your team's information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('teams.update', ['id' => $id]) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $team->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $team->description)" required autofocus autocomplete="description" />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="public" :value="__('Is public?')" />
            <x-text-input id="public" name="public" type="text" class="mt-1 block w-full" :value="old('public', $team->public)" required autofocus autocomplete="public" />
            <x-input-error class="mt-2" :messages="$errors->get('public')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
