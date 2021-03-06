@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @forelse($threads as $thread)
                    <div class="card mb-md-4">
                        <div class="card-header">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ route('threads.show', [$thread->channel->slug, $thread]) }}">
                                        {{ $thread->title }}
                                    </a>
                                </h4>

                                <a href="{{ route('threads.show', [$thread->channel->slug, $thread]) }}">
                                    <strong>{{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('reply', $thread->replies_count) }}</strong>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>
                @empty
                    <p>There are no relevant results at this time.</p>
                @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
