<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $team->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" >
                <h3>{{ $team->name }}</h3>
                <p>{{ $team->owner->username }}</p>
                <p>{{ $team->description }}</p>
                <p>{{ count($team->participants) }} participants</p>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('teams.partials.participant-list')
                    </div>
                </div>
                @if($team->owner->id == Auth::user()->id)
                    <a href="{{ $team->id }}\edit" class="vertical" style="width: 20%; float: right; margin: 2%; text-align: center">
                        <x-primary-button style="width: 100%">Edit team information</x-primary-button>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
