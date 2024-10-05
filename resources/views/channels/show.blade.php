@extends('template')

@section('content')
    <div class="my-10">
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="w-fit mx-auto my-2 py-1 px-2 border-2 border-red-300 text-red-400 rounded-md">{{$error}}</li>
                @endforeach
            </ul>
        @endif
        @if (Auth::id() && Auth::id() == $channel->user_id)
            <form id="update-channel-form" action="{{route('channels.update', $channel->id)}}" enctype="multipart/form-data" method="POSt">
                @csrf
                @method('PATCH')
                <div class="flex items-start mx-auto pb-10 gap-4 w-[50%]">
                    <div class="w-[200px] relative">
                        <img onclick="document.getElementById('image').click()" class="rounded-full cursor-pointer" style="width: 150px; height: 150px;" src="{{$channel->image() ? $channel->image() : '/def_profile.png'}}" alt="Bonnie image" />
                        <img src="/photo-camera.svg" class="bottom-0 right-0 absolute" style="width: 30px; height: 30px;" alt="">
                        <input onchange="document.getElementById('update-channel-form').submit()" type="file" name="image" id="image" class="hidden">
                    </div>
                 
                    <div class="flex flex-col w-[100%] gap-4">
                        <input type="text" name="name" class="border-[1px] rounded-lg py-1 px-2 border-gray-300" value="{{$channel->name}}">
                        <span class="text-gray-700">{{$channel->getSubscriptionCount()}} subscribers • 0 videos</span>
                        <textarea name="description" id="description" class="border-[1px] rounded-lg py-1 px-2 border-gray-300" style="width: 100%" rows="4">{{$channel->description ? $channel->description : 'No description available'}}</textarea>
                        <div class="flex mt-4 md:mt-6 gap-3">
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-[#ff302f] hover:bg-[#ff5c5c] rounded-lg focus:ring-4 focus:outline-none no-underline">
                                Subscribe</a>
                            <input onclick="document.getElementById('update-channel-form').submit()" type="button" value="Update channel" class="border-2 border-[#ff302f] text-[#ff302f] rounded-lg px-4">
                        </div>
                    </div>
                </div>
            </form>
        @else
        <div class="flex items-center mx-auto pb-10 gap-4 w-[50%]">
            <img class="rounded-full" style="width: 150px; height: 150px;" src="{{$channel->image() ? $channel->image() : '/def_profile.png'}}" alt="Bonnie image" />
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-semibold">{{$channel->name}}</h2>
                <span class="text-gray-700">{{$channel->getSubscriptionCount()}} subscribers • 0 videos</span>
                <span class="text-sm text-gray-500 dark:text-gray-400 text-wrap">{{$channel->description ? $channel->description : 'No description available'}}</span>
                <div id="app" class="flex mt-4 md:mt-6">
                        <subscribe-button></subscribe-button>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
