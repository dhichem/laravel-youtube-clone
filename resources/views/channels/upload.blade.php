@extends('template')

@section('content')
    <div id="app" class="my-10">
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="w-fit mx-auto my-2 py-1 px-2 border-2 border-red-300 text-red-400 rounded-md">{{$error}}</li>
                @endforeach
            </ul>
        @endif
        <channel-uploads :channel="{{$channel}}"></channel-uploads>
    </div>
@endsection
