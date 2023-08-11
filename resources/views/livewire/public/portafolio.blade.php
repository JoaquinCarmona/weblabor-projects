<div>
    <div class="w-screen h-screen items-center flex flex-col">
        <div class="w-80 md:w-80 lg:w-1/2 mt-10">

            <div class="flex justify-center">
                <div class="w-1/4 h-0.5 bg-pink-600 my-2 "></div>
            </div>
            <div class="flex justify-center">
                <h1 class="text-4xl text-font font-sans font-bold">Portafolio</h1>
            </div>
            <div class="flex justify-center">
                <div class="w-1/4 h-0.5 bg-pink-600 my-2 "></div>
            </div>

            <div class="mt-11">
                <div class="portfolio-list">
                    <ul class="grid grid-cols-3">
                        @foreach($projects as $project)
                            <li class="h-80">
                                <div class="w-full p-2 h-full container mx-auto relative">
                                    <img src="{{ asset('images/projects').'/'.$project->image }}" class="w-full h-full">
                                    <div class="hover:bg-pink-600 hover:bg-opacity-75 transition-all duration-300  w-full h-full absolute top-px left-px rounded-lg p-8 hover:text-white text-transparent " onclick="javascript:return alert('To be continue...')" >
                                        {{$project->title}} <br>
                                        {!! $project->description !!}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{ $projects->links() }}
            </div>
            <div class="mt-11 my-11 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <a href="{{route('login')}}">Login</a>
            </div>
        </div>
    </div>

</div>

