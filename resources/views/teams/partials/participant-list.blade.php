<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Team participants') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("List of all participants in your team.") }}
        </p>
        <?php
            $participants = $team->getParticipants();
        ?>
        @if($participants->count() == 0)
            <p>There are no participants in your team currently!</p>
        @else

        @foreach($participants as $participant)
            <p style="padding-top: 0.2rem; font-weight: bold">{{ $participant->username }}</p>
        @endforeach
        @endif
    </header>
</section>
