<?php
use App\Services\ProjectService;
?>

@php($tasks = ProjectService::getProjectTasks(request()->project_id))
<div class="calendar">
    <div class="month">
        <ul>
            <li class="prev">&#10094;</li>
            <li class="next">&#10095;</li>
            <li>
                April<br>
                <span style="font-size:18px">2023</span>
            </li>
        </ul>
    </div>

    <ul class="weekdays">
        <li>Mo</li>
        <li>Tu</li>
        <li>We</li>
        <li>Th</li>
        <li>Fr</li>
        <li>Sa</li>
        <li>Su</li>
    </ul>

    <ul class="days">
        <li class="inactive-day">0</li>
        <li class="inactive-day">0</li>
        <li class="inactive-day">0</li>
        <li class="inactive-day">0</li>
        @for($i = 1; $i <= 30; $i++)
            @if($i == date('d'))
                <li class="current-day">
                    <div class="date">
                        <span style="font-size: 1rem">{{ $i }}</span>
            @else
                <li>
                    <div class="date">
                        <span style="font-size: 1rem">{{ $i }}</span>
            @endif

            @foreach($tasks as $task)
                @if(date('d', strtotime($task->due_date)) == $i)
                    <div class="cal-task-day">
                        <div class="cal-task-day-head">
                            <h2>{{ $task->title }}</h2>
                        </div>
                        <div class="cal-task-day-body">
                            <p>{{ $task->description }}</p>
                            <p class="cal-task-due-date">Due: {{ date("g:i", strtotime($task->due_date)) }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
                    </div>
            </li>
        @endfor
    </ul>
</div>

