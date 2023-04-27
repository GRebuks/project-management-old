@php use function PHPUnit\Framework\isNull; @endphp
<x-workspace-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team projects page') }}
        </h2>
        @if($projects->isEmpty() === false)
            @foreach($projects as $project)
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <div class="text-sm leading-5 font-medium text-gray-900" style="border: 1px solid black">
                        <h2>{{ $project->name }}</h2>
                        <p>{{ $project->description }}</p>
                    </div>
                    <div class="ml-2 flex-shrink-0 flex">
                        <a href="{{ route($type . '.projects.show', ['id' => $id, 'project_id' => $project->id]) }}" class="inline-flex items-center px-2.5 py-0.5 border border-transparent text-xs leading-4 font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                            {{ __('View') }}
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <p>No projects created yet.</p>
        @endif

            <!-- Create project button -->
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 text-right sm:px-6">
                <div class="text-sm leading-5 font-medium text-gray-900">
                    <a href="{{ route($type . '.projects.create', ['id' => $id]) }}"
                       class="inline-flex items-center px-2.5 py-0.5 border border-transparent text-xs leading-4 font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                        {{ __('Create project') }}
                    </a>
                </div>
            </div>

    </x-slot>
</x-workspace-layout>
