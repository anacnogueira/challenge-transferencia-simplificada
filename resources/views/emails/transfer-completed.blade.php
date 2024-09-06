@extends('emails.layouts.default')

@section('title', $title)

@section('content')
    <p>Hello</p>
    <p>You have just received a transfer worth <b>{{ sprintf("%.2f", $value); }}</b> from <b>{{ $payerName }}</b></p>
    <p>Greetings,</p>
    <p>{{ env('APP_NAME')}}</p>
@endsection