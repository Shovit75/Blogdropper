@extends('frontend.partials.body')

@section('body')
<section class="background"> <!-- Color for background-->

        <!-- Page Header-->
            <div id="backgroundimage" style="background-image: url('{{ asset('storage/'.$posts->banner) }}');">
                <div class="container-lg">
                    <div class="row justify-content-center">
                    <div class="col-md-8">
                    <div class="title pt-md-5 pt-lg-0">
                        <div>{{$posts->title}}
                        <div class="subtitle">{{$posts->description}}</div>
                        <span>Posted by</span>
                        <span style="font-family: Arial, sans-serif;">
                            {{$posts->author}}
                        </span>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>

        <!-- Post Content-->
        <article class="forsmallpost">
            <div class="container-lg">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 text-center post-md-4">
                       <p>{{$posts->introduction}}</p>
                       @php
                        $multipleImages = json_decode($posts->multipleimages);
                        @endphp
                        <div class="container-fluid mb-3">
                            <div class="row">
                                @php
                                $totalImages = count($multipleImages);
                                $columns = $totalImages == 6 ? 3 : min($totalImages, 2); // Determine the number of columns based on the number of images
                                $columnSize = $totalImages == 6 ? '33.3%' : (100 / $columns) . '%'; // Calculate column size based on the number of columns
                                @endphp
                                @foreach ($multipleImages as $image)
                                <div class="column" style="flex: 0 0 {{ $columnSize }}; max-width: {{ $columnSize }};">
                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail aboutimg" onclick="openFullscreen(this)"/>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <p>{{$posts->body}}</p>
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
                            <div class="carousel-inner">
                                @foreach ($multipleImages as $key => $multipleimg)
                                    <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                                        <img src="{{ asset('storage/' . $multipleimg) }}" class="d-block w-100 postimg img-thumbnail" alt="multipleimg">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <br>
                        <p>{{$posts->conclusion}}</p>
                        @if($posts->link)
                        <p>Social Website:
                         <a href="{{$posts->link}}" class="text-success logo">{{$posts->link}}</a>
                        </p>
                        @endif
                        @section('head')
                            @if($posts->slug)
                                <?php
                                    $canonicalUrl = str_replace('{slug}', $posts->slug, env('POST_CANONICAL_URL'));
                                ?>
                                <link rel="canonical" href="{{ $canonicalUrl }}" />
                            @endif
                            <style>
                                    .post-md-4{
                                        font-size: 1.20rem;
                                    }
                                @media (min-width: 768px) and (max-width: 991.98px) {
                                    .post-md-4 {
                                        font-size: 1.70rem;
                                        }
                                    .title {
                                        font-size: 1.40rem;
                                        }
                                    }
                                    .img-thumbnail {
                                      cursor: pointer;
                                    }
                                    .container-fluid {
                                      display: flex;
                                      flex-wrap: wrap;
                                    }
                                    /* Create four equal columns that sits next to each other */
                                    .column {
                                      flex: 0 0 50%; /* Initially, each column takes up 50% of the container's width */
                                      max-width: 50%;
                                      padding: 0.25rem 0.25rem; /* Add some spacing between columns */
                                    }
                                    .column img {
                                      width: 100%;
                                      height: 100%;
                                      max-width: 100%; /* Ensure images don't exceed column width */
                                      max-height: 100%; /* Ensure images don't exceed column width */
                                    }
                                    @media (min-width: 768px) {
                                      .container-fluid .column {
                                        flex-basis: 33.33%; /* Each column takes up 33.33% of the container's width for medium-sized screens and above */
                                        max-width: 33.33%;
                                      }
                                    }
                            </style>
                        @endsection
                    </div>
                </div>
            </div>
        </article>

        <!-- Comments Section -->

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center text-secondary">Add Comments</h4>
                            @if(Auth::guard('webuser')->check())
                            <h6 class="text-center text-secondary">What are your thoughts on this article ?</h6>
                            @else
                            <h6 class="text-center text-secondary"><a href="{{route('frontend.login')}}">Login to comment</a></h6>
                            @endif
                            @if (count($posts->comments) >=1)
                            <hr />
                            @include('frontend.partials.commentDisplay', ['comments' => $posts->comments, 'post_id' => $posts->id])
                            <hr/>
                            @if(Auth::guard('webuser')->check())
                            <h5 class="text-center text-success">Add comments</h4>
                            @else
                            <h5 class="text-center text-secondary">
                                <a href="{{route('frontend.login')}}">Login to comment</a>
                            </h5>
                            @endif
                            @endif
                            @if(Auth::guard('webuser')->check())
                            <form method="post" action="{{ route('comments.store') }}">
                                @csrf
                                <div class="form-group">
                                    @if ($errors->any())
                                        <div class="text-danger text-center">
                                            <ul class="list-unstyled">
                                                @foreach ($errors->all() as $error)
                                                    <li class="">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <textarea class="form-control" name="body" rows="6" required></textarea>
                                    <input type="hidden" name="post_id" value="{{ $posts->id }}"/>
                                </div>
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success mx-1" value="Add Comment" />
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </section>
@endsection
@section('scripts')
<script>
    function openFullscreen(element) {
    var element = element;
    if (element.requestFullscreen) {
        element.requestFullscreen();
    } else if (element.mozRequestFullScreen) { /* Firefox */
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
        element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) { /* IE/Edge */
        element.msRequestFullscreen();
    }
    }
</script>
@endsection
