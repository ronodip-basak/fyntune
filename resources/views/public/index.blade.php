@extends('public.layout')

@section('content')
    <div style="width: 100%; background:url('/photo-1625689009224-b9b03467e687.jpg'); height: 60vh;background-position: center; background-repeat: no-repeat; background-size: cover;">
        <div style="align-content: center; display: grid; height:60vh; text-align: center;">
            <h3 style="color: whitesmoke;">@if(session()->has('current_test'))Continue From where you left off? @else Do you have what it takes to answer all correctly? @endif</h3>
            <div>
                @if(session()->has('current_test'))
                <a style="margin-bottom: 1rem;" href="{{ route('test.index', session()->get('current_test')) }}" class="btn btn-primary">Continue</a>
                @endif


                <form method="post" action="{{ route('test.start') }}">
                    @csrf
                    <button class="btn btn-primary">@if(session()->has('current_test'))Start a new one @else Let's find out! @endif </button>
                </form>
            </div>

        </div>
    </div>
@endsection
