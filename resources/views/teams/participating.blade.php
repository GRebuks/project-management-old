<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Participating teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" >
                <h2>Owned teams</h2>
                @if(!empty($ownedTeams))
                    @foreach($ownedTeams as $team)
                        <div style="display: flex; flex-direction: column; padding: 2%; border-radius: 10px; border: 1px solid blueviolet">
                            <h3><a href="{{ $team->id }}">{{ $team->name }}</a></h3>
                            <p>{{ $team->owner->username }}</p>
                            <p>{{ $team->description }}</p>
                            <p>{{ count($team->participants) }} participants</p>
                            <a href="{{ route('teams.workspace', ['id' => $team->id]) }}" class="vertical" style="width: 20%; float: right; margin: 2%; text-align: center">
                                <x-primary-button style="width: 100%">Team workspace</x-primary-button>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="p-6 text-gray-900">
                        {{ __("You currently don't own any teams! Create your first team!") }}
                    </div>
                    <a href="teams\create" class="vertical" style="width: 20%; float: right; margin: 2%; text-align: center">
                        <x-primary-button style="width: 100%">Create team</x-primary-button>
                    </a>
                @endif

                <h2>Member teams</h2>
                @if(!empty($memberTeams))
                    @foreach($memberTeams as $team)
                        <div style="display: flex; flex-direction: column; padding: 2%; border-radius: 10px; border: 1px solid blueviolet">
                            <h3>{{ $team->name }}</h3>
                            <p>{{ $team->owner->username }}</p>
                            <p>{{ $team->description }}</p>
                            <p>{{ count($team->participants) }} participants</p>
                            <form action="{{ route('teams.leave', ['id' => $team->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="team_id" value="{{ $team->id }}">
                                <button type="submit">Leave</button>
                            </form>
                            <!-- route to team workspace -->
                            <a href="{{ route('teams.workspace', ['id' => $team->id]) }}" class="vertical" style="width: 20%; float: right; margin: 2%; text-align: center">
                                <x-primary-button style="width: 100%">Team workspace</x-primary-button>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
