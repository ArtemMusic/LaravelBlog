@extends('layouts.main')

@section('content')
<main class="blog-post">
    <div class="container">
        <h1 class="edica-page-title" data-aos="fade-up">{{$post->title}}</h1>
        <p class="edica-blog-post-meta" data-aos="fade-up" data-aos-delay="200">{{$date->translatedFormat('F')}} {{$date->format('d')}}, 20{{$date->format('y')}} {{$date->format('H:i')}} • {{$post->comments->count()}} Комментариев</p>
        <section class="blog-post-featured-img" data-aos="fade-up" data-aos-delay="300">
            <img src="{{asset('storage/' . $post->main_image)}}" alt="featured image" class="w-100" style="border:1px solid transparent; border-radius:10px;">
        </section>
        <section class="post-content">
            <div class="row">
                <div class="col-lg-9 mx-auto" data-aos="fade-up">
                    {!! $post->content !!}
                </div>
            </div>
        </section>
        <div class="row mt-4">
            <div class="col-lg-9 mx-auto">
                <section class="py-3" data-aos="fade-up">
                    @auth()
                    <form action="{{route('post.like.store', $post->id)}}" method="POST">
                        @csrf
                        <span>{{$post->liked_users_count}}</span>
                        <button type="submit" class="border-0 bg-transparent">
                            @if(auth()->user()->likedPosts->contains($post->id))
                            <i class="fas fa-heart"></i>
                            @else
                            <i class="far fa-heart"></i>
                            @endif
                        </button>
                    </form>
                    @endauth()
                    @guest()
                    <div>
                        <span>{{$post->liked_users_count}}</span>
                        <a href="{{route('login')}}" style="color:black;"><i class="far fa-heart"></i></a>
                    </div>
                    @endguest
                </section>
                @if($relatedPosts->count() > 0)
                <section class="related-posts">
                    <h2 class="section-title mb-4" data-aos="fade-up">Схожие посты</h2>
                    <div class="row">
                        @foreach($relatedPosts as $relatedPost)
                        <div class="col-md-4" data-aos="fade-right" data-aos-delay="100">
                            <a href="{{route('post.show', $relatedPost->id)}}"><img src="{{asset('storage/'. $relatedPost->preview_image)}}" alt="related post" class="post-thumbnail" style="border:1px solid transparent; border-radius:10px;"></a>
                            <p class="post-category">{{$relatedPost->category->title}}</p>
                            <a href="{{route('post.show', $relatedPost->id)}}">
                                <h5 class="post-title">{{$relatedPost->title}}</h5>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </section>
                <section class="comment-list mb-5" data-aos="fade-up">
                    <h3 class="mb-4">Комментарии ({{$post->comments->count()}})</h3>
                    @foreach($post->comments as $comment)
                    <div class="comment-text mb-3" data-aos="fade-right" data-aos-delay="100">
                        <span class="username">
                            <div><b>{{$comment->user->name}}</b></div>
                            <span class="text-muted float-right">{{$comment->dateAsCarbon->diffForHumans()}}</span>
                        </span><!-- /.username -->
                        {{$comment->message}}
                    </div>
                    @endforeach
                </section>
                @auth()
                <section class="comment-section">
                    <h2 class="section-title mb-5" data-aos="fade-up">Оставить комментарий</h2>
                    <form action="{{route('post.comment.store', $post->id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12" data-aos="fade-up">
                                <label for="message" class="sr-only">Комментарий</label>
                                <textarea name="message" id="message" class="form-control" placeholder="Комментарий" rows="10"></textarea>
                                <input type="hidden" value="{{$post->id}}" name="post_id">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" data-aos="fade-up">
                                <input type="submit" value="Отправить" class="btn btn-warning">
                            </div>
                        </div>
                    </form>
                </section>
                @endauth()
            </div>
        </div>
    </div>
</main>
@endsection