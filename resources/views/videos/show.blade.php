@extends('template')

@section('content')
    <div class="py-6 px-8 flex gap-6">
        <div id="app" class="w-[65%] flex flex-col gap-3">
            @if ($video->editable())
                <form id="update-video-form" action="{{route('videos.update', $video->id)}}" method="POST" class="flex flex-col gap-3">
                @csrf
                @method('PUT')
            @endif
            <video-js id="video" class="vjs-default-skin vjs-big-play-centered" controls preload="auto"
                data-setup='{"fluid": true}'>
                <source src="{{ asset(Storage::url("streamable_videos/{$video->id}/{$video->id}.m3u8")) }}"
                    type="application/x-mpegURL">
            </video-js>

            @if ($video->editable())
                <input type="text" value="{{ $video->title }}" name="title" class="border-none text-xl font-bold">
            @else
                <span class="text-xl font-bold">{{ $video->title }}</span>
            @endif

            <div id="app" class="flex justify-between">
                <div class="flex gap-2">
                    <img class="rounded-full" style="width: 40px; height: 40px;"
                        src="{{ $video->channel->image() ? $video->channel->image() : '/def_profile.png' }}"
                        alt="Bonnie image" />
                    <div class="flex flex-col">
                        <span class="font-semibold text-[16px]">{{ $video->channel->name }}</span>
                        <subscribers-videos-count :subscriber-count="{{ $video->channel->getSubscriptionCount() }}"
                            :format-type="'video'"></subscribers-videos-count>
                    </div>
                    <subscribe-button class="mx-4" :channel="{{ $video->channel }}"
                        :subscription-prop="{{ $video->channel->isSubscribed() }}"
                        :is-subscribed-prop="{{ $video->channel->isSubscribed() ? true : false }}"></subscribe-button>
                </div>
                <div>
                    <like-unlike-button :like-count-prop="{{$video->getUpVotesCount()}}" :unlike-count-prop="{{$video->getDownVotesCount()}}"
                        :is-reacted-to-prop="{{$video->checkIfReacted() ? $video->checkIfReacted() : null}}" owner="{{$video->channel->user_id}}"
                        entity-id="{{$video->id}}" :entity-type="'video'"></like-unlike-button>
                </div>
            </div>

            <div class="bg-gray-300 flex flex-col gap-1 rounded-lg p-2">
                <div class="flex gap-3 font-semibold">
                    <span>{{ $video->viewsCount }} {{ Str::plural('view', $video->viewsCount) }}</span>
                    <span>{{ $video->created_at }}</span>
                </div>
                <div>
                    @if ($video->editable())
                        <textarea name="description" id="description" class="border-[1px] rounded-lg py-1 px-2 border-gray-300" style="width: 100%" rows="4">{{$video->description}}</textarea>
                        <div class="flex justify-end">
                            <input onclick="document.getElementById('update-video-form').submit()" type="button" value="Update video" class="border-2 py-2 border-[#ff302f] text-[#ff302f] rounded-lg px-4">
                        </div>
                    @else
                        {{$video->description}}
                    @endif
                </div>
            </div>
            @if ($video->editable())
                </form>
            @endif

  
            <div class="flex flex-col gap-2 w-full">
                
                <span>{{$video->getCommentsCount()}} Comments</span>

                <comment :video="{{$video}}" :comments="{{$video->comments}}" 
                    profile-img="{{ Auth::check() && auth()->user()->channel->image() ? auth()->user()->channel->image() : '/def_profile.png' }}"></comment>
            </div>
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
        window.CURRENT_VIDEO = '{{ $video->id }}'
    </script>
    <script src="{{ asset('js/videoPlayer.js') }}"></script>
@endsection
