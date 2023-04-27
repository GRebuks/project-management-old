<?php
use App\Services\ProjectService;
?>\
@php($tasks = ProjectService::getProjectTasks(request()->project_id))
<x-workspace-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project: ') . $project->name }}
        </h2>
    </x-slot>
    @include('workspace\partials\project-navigation')
    @include('workspace\projects\partials\calendar-board')
</x-workspace-layout>
