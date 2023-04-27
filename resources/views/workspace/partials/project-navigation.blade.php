<?php
    $path = request()->path();
    $path = explode('/', $path)[0];
    $id = request()->id;
    $project_id = request()->project_id;
?>
<div class="flex flex-col flex-1 w-full max-w-7xl mx-auto sm:px-6 lg:px-8">
    <ul>
        <li><a href="{{ route($path . '.projects.show', ['id' => $id, 'project_id' => $project_id]) }}">Home</a></li>
        <li><a href="{{ route($path . '.projects.tasks', ['id' => $id, 'project_id' => $project_id]) }}">Tasks</a></li>
        <li><a href="{{ route($path . '.projects.files', ['id' => $id, 'project_id' => $project_id]) }}">Files</a></li>
        <li><a href="{{ route($path . '.projects.calendar', ['id' => $id, 'project_id' => $project_id]) }}">Calendar</a></li>
        <li><a href="{{ route($path . '.projects.notes', ['id' => $id, 'project_id' => $project_id]) }}">Notes</a></li>
        <li><a href="{{ route($path . '.projects.settings', ['id' => $id, 'project_id' => $project_id]) }}">Settings</a></li>
    </ul>
</div>
