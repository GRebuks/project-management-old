<x-workspace-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project: ') . $project->name }}
        </h2>
    </x-slot>
    @include('workspace\partials\project-navigation')
</x-workspace-layout>
