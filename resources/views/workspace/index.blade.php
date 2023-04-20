<x-workspace-layout>
    <x-slot name="header">
        @if (Str::contains(request()->url(), 'users'))
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User workspace page') }}
        </h2>
        @elseif (Str::contains(request()->url(), 'teams'))
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Team workspace page') }}
            </h2>
            @include('workspace.partials.notifications')
        @endif
    </x-slot>
</x-workspace-layout>
