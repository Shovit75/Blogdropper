    @foreach ($moreposts as $post)
        <div class="my-4 mx-2 d-flex align-items-center">
            <a href="{{ url('blog/title/' . $post->slug) }}" class="d-flex">
                <img class="roundimg" src="{{ asset('storage/' . $post->image) }}" height="100" width="100" alt="Blog">
                <div class="ms-2 px-2 d-flex flex-column justify-content-center fontsizee">
                    <span class="mb-2"> {{$post->title}} </span>
                    <span style="font-family: Arial, sans-serif;">
                        <span class="fas fa-user"></span>
                        {{$post->author}}
                        <br>
                        <span class="fas fa-calendar-alt"></span>
                    {{ \Carbon\Carbon::parse($post->date)->format('d-M-Y') }}
                    </span>
                </div>
            </a>
        </div>
    @endforeach
