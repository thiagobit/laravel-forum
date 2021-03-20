@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Forum Threads') }}</div>

                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
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

                                <div class="body">{{ $thread->body }}</div>
                            </article>

                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
