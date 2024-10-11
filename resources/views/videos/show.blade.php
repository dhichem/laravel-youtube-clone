@extends('template')

@section('content')
    <div class="py-6 px-8 flex gap-6">
        <div class="w-[65%] flex flex-col gap-4">
            <video-js id="video" class="vjs-default-skin vjs-big-play-centered" controls preload="auto"
                data-setup='{"fluid": true}'>
                <source src="{{ asset(Storage::url("streamable_videos/{$video->id}/{$video->id}.m3u8")) }}"
                    type="application/x-mpegURL">
            </video-js>
            <span class="text-2xl font-semibold">{{ $video->title }}</span>
        </div>
        <div class="flex-1 flex">
            <span class="text-lg">Suggestions</span>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/8.16.1/video.min.js"></script>
    <script>
        videojs('video')
    </script>
@endsection
