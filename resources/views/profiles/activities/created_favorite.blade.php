@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ route('threads.show', [$activity->subject->favorited->thread->channel, $activity->subject->favorited->thread]) }}#reply-{{ $activity->subject->favorited->id }}">
            {{ $profileUser->name }} favorited a replay.
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
