@extends("layout.main")

@section("content")

    <div class="alert alert-success" role="alert">
        下面是搜索"{{$query}}"出现的文章，共{{$posts->total()}}条
    </div>

    <div class="col-sm-8 blog-main">
        @foreach($posts as $post)
            <div class="blog-post">
                <h2 class="blog-post-title">
                    <a href="/posts/{{$post->id}}" >
                        @if (isset($post->highlight['title']))
                            @foreach ($post->highlight['title'] as $item)
                                {!! $item !!}
                            @endforeach
                        @else
                            {{ $post->title }}
                        @endif
                    </a>
                </h2>
                <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by <a href="#">Mark</a></p>

                <p>
                    @if (isset($post->highlight['content']))
                        @foreach ($post->highlight['content'] as $item)
                            ......{!! $item !!}......
                        @endforeach
                    @else
                        {!! str_limit($post->content, 200, '...') !!}
                    @endif
                </p>
            </div>
        @endforeach

        {{$posts->links()}}
    </div><!-- /.blog-main -->


@endsection