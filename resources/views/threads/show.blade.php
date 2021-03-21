@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </span>

                            @can ('update', $thread)
                            <form method="POST" action="{{ route('threads.destroy', [$thread->channel, $thread]) }}">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-link" type="submit">Delete Thread</button>
                            </form>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div class="mt-md-4">
                    {{ $replies->links() }}
                </div>

                @if (auth()->check())
                    <form class="mt-md-4" method="POST" action="{{ route('replies.store', [$thread->channel, $thread]) }}">
                        @csrf

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-outline-secondary">Post</button>
                    </form>
                @else
                    <p class="text-center mt-md-4">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a>, and currently has
                            {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
