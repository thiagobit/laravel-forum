@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="pb-2 mt-4 mb-4 border-bottom">
            <h1>
                {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>

        @foreach($threads as $thread)
        <div class="row">
            <div class="col-md-8 mb-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="#">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </span>

                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{ $threads->links() }}
    </div>
@endsection
