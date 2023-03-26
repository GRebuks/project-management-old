<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" >
                @if(!empty($teams))
                    @foreach($teams as $team)
                        <div style="display: flex; flex-direction: column; padding: 2%; border-radius: 10px; border: 1px solid blueviolet">
                            <h3>{{ $team->name }}</h3>
                            <p>{{ $team->owner->username }}</p>
                            <p>{{ $team->description }}</p>
                            <p>{{ count($team->participants) }} participants</p>
                            @if($team->isOwnedByLoggedUser())
                                <a href="{{ route('teams.edit', ['id' => $team->id]) }}"><h2>OWNER</h2></a>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="p-6 text-gray-900">
                        {{ __("No teams are currently registered! Be the first one who creates a team!") }}
                    </div>
                @endif
                <a href="teams\create" class="vertical" style="width: 20%; float: right; margin: 2%; text-align: center">
                    <x-primary-button style="width: 100%">Create team</x-primary-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
