<?php
    use App\Services\ProjectService;
?>
<x-workspace-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project: ') . $project->name }}
        </h2>
    </x-slot>
    @include('workspace\partials\project-navigation')
    @php($tasks = ProjectService::getProjectTasks(request()->project_id))
    @if($tasks->count() == 0)
        <p>There are no tasks in your project currently!</p>
    @else
        @include('workspace\projects\partials\kanban-board')
{{--        @foreach($tasks as $task)--}}
{{--            <div class="py-12">--}}
{{--                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">--}}
{{--                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                        <div class="max-w-xl">--}}
{{--                            <h2>{{ $task->title }}</h2>--}}
{{--                            <p>{{ $task->description }}</p>--}}
{{--                            <h3>Created at: {{ $task->created_at }}</h3>--}}
{{--                            <p>Due date: {{ $task->due_date }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('workspace\projects\partials\add-kanban-column-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('workspace\projects\partials\add-task-form')
                </div>
            </div>
        </div>
    </div>

</x-workspace-layout>
