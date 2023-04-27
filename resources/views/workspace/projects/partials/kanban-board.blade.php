<?php
use App\Services\ProjectService;
?>

@php($tasks = ProjectService::getProjectTasks(request()->project_id))
@if($tasks->count() != 0)
    <div class="board">
        @foreach($columns as $column)
            <div class="board-column">
                <div class="board-column-content">
                    <div class="board-column-head">
                        <h2 class="column-title">{{ $column->title }}</h2>
                    </div>
                    @foreach($tasks as $task)
                        @if($task->kanban_column_id == $column->id)
                            <div class="board-column-card">
                                <div class="board-column-card-head">
                                    <h2>{{ $task->title }}</h2>
                                </div>
                                <div class="board-column-card-body">
                                    <p>{{ $task->description }}</p>
                                    <p class="task-due-date">Due date: {{ $task->due_date }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif
