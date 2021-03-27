<div id="reply-{{ $reply->id }}" class="card mt-md-4">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profiles.show', $reply->owner) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...
            </h5>

            <div>
                <form method="POST" action="{{ route('replies.favorites', $reply) }}">
                    @csrf

                    <button class="btn btn-outline-secondary" type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ \Illuminate\Support\Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
