@php use App\Models\User;use App\Services\NotificationService; @endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Notifications') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("List of all notifications in your team.") }}
        </p>
        <?php
        $notifications = NotificationService::getTeamNotifications(request()->id);
        ?>
        @if($notifications->count() == 0)
            <p>There are no notifications in your team currently!</p>
        @else
            @foreach($notifications as $notification)
                <div style="padding: 1rem; background-color: #eeeeee; border-radius: 0.5rem; margin-top: 0.5rem">
                    <h2 style="font-size: 1.2rem; font-weight: bold">{{ $notification->title }}</h2>
                    <p>{{ $notification->message }} by {{  User::find($notification->user_id)->username }}</p>
                    <h3>{{ $notification->created_at }}</h3>
                </div>
            @endforeach
        @endif
    </header>
</section>
