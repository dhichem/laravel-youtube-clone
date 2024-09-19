@extends('template')

@section('content')
    <div class="my-10">
        @if (Auth::id() && Auth::id() == $channel->user_id)
            <form id="update-channel-form" action="{{route('channels.update', $channel->id)}}" enctype="multipart/form-data" method="POSt">
                @csrf
                @method('PATCH')
                <div class="flex items-start mx-auto pb-10 gap-4 w-[50%]">
               
                    <img onclick="document.getElementById('image').click()" class="rounded-full cursor-pointer" style="width: 150px; height: 150px;" src="{{$channel->photo ? $channel->photo : '/def_profile.png'}}" alt="Bonnie image" />
                    <input onchange="document.getElementById('update-channel-form').submit()" type="file" name="image" id="image" class="hidden">
                 
                    <div class="flex flex-col w-[100%] gap-4">
                        <input type="text" name="name" class="border-[1px] rounded-lg py-1 px-2 border-gray-300" value="{{$channel->name}}">
                        <textarea name="description" id="description" class="border-[1px] rounded-lg py-1 px-2 border-gray-300" style="width: 100%" rows="4">{{$channel->description ? $channel->description : 'No description available'}}</textarea>
                        <div class="flex mt-4 md:mt-6 gap-3">
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-[#ff302f] hover:bg-[#ff5c5c] rounded-lg focus:ring-4 focus:outline-none no-underline">
                                Subscribe</a>
                            <input type="button" value="Update channel" class="border-2 border-[#ff302f] text-[#ff302f] rounded-lg px-4">
                        </div>
                    </div>
                </div>
            </form>
        @else
        <div class="flex items-center mx-auto pb-10 gap-4 w-[50%]">
            <img class="rounded-full" style="width: 150px; height: 150px;" src="{{$channel->photo ? $channel->photo : '/def_profile.png'}}" alt="Bonnie image" />
            <div class="flex flex-col">
                <h5 class="mb-1 text-xl font-medium">{{$channel->name}}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400 text-wrap">{{$channel->description ? $channel->description : 'No description available'}}</span>
                <div class="flex mt-4 md:mt-6">
                    <a href="#"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-[#fd8484] rounded-lg focus:ring-4 focus:outline-none no-underline">
                        Subscribe</a>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
