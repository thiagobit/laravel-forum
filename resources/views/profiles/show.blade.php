@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-md-4">
                <div class="pb-2 mt-4 mb-4 border-bottom">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>

                @foreach($activities as $date => $activity)
                    <h3 class="pb-2 mt-4 mb-4 border-bottom">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @if($record->subject)
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @endforeach

                {{--{{ $threads->links() }}--}}
            </div>
        </div>
    </div>
@endsection
