@extends('public.layout')

@section('content')
    <div style="text-align: center; padding-top: 5rem;" class="container">
        <h2>You Completed The Quiz</h2>
        <br />
        <p>Below are your results:</p>
        <br />
        <h2>{{ $test->score_recieved }} out of {{ $test->total_score }} questions, {{ round(($test->score_recieved * 100 / $test->total_score), 2) }}%</h2>
    </div>
@endsection