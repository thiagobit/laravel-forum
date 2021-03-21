@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-md-4">
                <div class="pb-2 mt-4 mb-4 border-bottom">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach($threads as $thread)
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">{{ $thread->title }}</a>
                            </span>

                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @endforeach

                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
