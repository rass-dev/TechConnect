@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, TechConnect  site, best online shopping">
    <meta name="description" content="{{$product_detail->summary}}">
    <meta property="og:url" content="{{route('product-detail', $product_detail->slug)}}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$product_detail->title}}">
    <meta property="og:image" content="{{$product_detail->photo}}">
    <meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title', 'TechConnect | Products')
@section('main-content')

            <!-- Breadcrumbs -->
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bread-inner">
                                <ul class="bread-list">
                                    <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                                    <li class="active"><a href="">Shop Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumbs -->

            <!-- Shop Single -->
            <section class="shop single section">
                        <div class="container">
                            <div class="row"> 
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <!-- Product Slider -->
                                            <div class="product-gallery">
                                                <!-- Images slider -->
                                                <div class="flexslider-thumbnails">
                                                    <ul class="slides">
                                                        @php 
                                                                                                                    $photo = explode(',', $product_detail->photo);
                                                            // dd($photo);
                                                        @endphp
                                                        @foreach($photo as $data)
                                                            <li data-thumb="{{ asset($data) }}" rel="adjustX:10, adjustY:">
                                                                <img src="{{ asset($data) }}" alt="product photo">
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                                <!-- End Images slider -->
                                            </div>
                                            <!-- End Product slider -->
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="product-des">
                                                <!-- Description -->
                                                <div class="short">
                                                    <h4>{{$product_detail->title}}</h4>
                                                    <div class="rating-main">
                                                        <ul class="rating">
                                                            @php
                                                                $rate = ceil($product_detail->getReview->avg('rate'))
                                                            @endphp
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($rate >= $i)
                                                                        <li><i class="fa fa-star"></i></li>
                                                                    @else 
                                                                        <li><i class="fa fa-star-o"></i></li>
                                                                    @endif
                                                                @endfor
                                                        </ul>
                                                        <a href="#" class="total-review">({{$product_detail['getReview']->count()}}) Review</a>
                                                    </div>
                                                    @php 
                                                        $after_discount = ($product_detail->price - (($product_detail->price * $product_detail->discount) / 100));
                                                    @endphp
                                                    <p class="price"><span class="discount">₱ {{number_format($after_discount, 2)}}</span><s>₱ {{number_format($product_detail->price, 2)}}</s> </p>
                                                    <p class="description">{!!($product_detail->summary)!!}</p>
                                                </div>
                                                <!--/ End Description -->
                                                <!-- Color -->
                                                {{-- <div class="color">
                                                    <h4>Available Options <span>Color</span></h4>
                                                    <ul>
                                                        <li><a href="#" class="one"><i class="ti-check"></i></a></li>
                                                        <li><a href="#" class="two"><i class="ti-check"></i></a></li>
                                                        <li><a href="#" class="three"><i class="ti-check"></i></a></li>
                                                        <li><a href="#" class="four"><i class="ti-check"></i></a></li>
                                                    </ul>
                                                </div> --}}
                                                <!--/ End Color -->
                                                <!-- Size -->
                                                @if($product_detail->size)
                                                @endif
                                                <!--/ End Size -->
                                                <!-- Product Buy -->
                                                <div class="product-buy">
                                                    <form action="{{route('single-add-to-cart')}}" method="POST">
                                                        @csrf 
                                                        <div class="quantity">
                                                            <h6>Quantity :</h6>
                                                            <!-- Input Order -->
                                                            <div class="input-group">
                                                                <div class="button minus">
                                                                    <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                                        <i class="ti-minus"></i>
                                                                    </button>
                                                                </div>
                                                                <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                                                <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1" id="quantity">
                                                                <div class="button plus">
                                                                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                                        <i class="ti-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <!--/ End Input Order -->
                                                        </div>
                                                        <div class="add-to-cart mt-4">
                                                            <button type="submit" class="btn">Add to cart</button>
                                                            <a href="{{route('add-to-wishlist', $product_detail->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                                        </div>
                                                    </form>

                                                    <p class="cat">Category :<a href="{{route('product-cat', $product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a></p>
                                                    @if($product_detail->sub_cat_info)
                                                        <p class="cat mt-1">Sub Category :<a href="{{route('product-sub-cat', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a></p>
                                                    @endif
                                                    <p class="availability">Stock : @if($product_detail->stock > 0)<span class="badge badge-success">{{$product_detail->stock}}</span>@else <span class="badge badge-danger">{{$product_detail->stock}}</span>  @endif</p>
                                                </div>
                                                <!--/ End Product Buy -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="product-info">
                                                <div class="nav-main">
                                                    <!-- Tab Nav -->
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a></li>
                                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews</a></li>
                                                    </ul>
                                                    <!--/ End Tab Nav -->
                                                </div>
                                                <div class="tab-content" id="myTabContent">
                                                    <!-- Description Tab -->
                                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                                        <div class="tab-single">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="single-des">
                                                                        <p>{!! ($product_detail->description) !!}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/ End Description Tab -->

    <!-- Reviews Tab -->
    <div class="tab-pane fade" id="reviews" role="tabpanel">
        <div class="tab-single review-panel">
            <div class="row">
                <div class="col-12">

     {{-- =================== Reviews List =================== --}}
    <div class="ratting-main">
        @php
            $avgRate = $product_detail->getReview->avg('rate');
            $roundedAvg = number_format($avgRate, 1); // show one decimal
            $totalReviews = $product_detail->getReview->count();
        @endphp

        <div class="avg-ratting">
            <div class="overall-stars">
                <ul class="rating">
                    @for($i = 1; $i <= 5; $i++)
                        <li><i class="fa {{ $i <= round($avgRate) ? 'fa-star' : 'fa-star-o' }}"></i></li>
                    @endfor
                </ul>
            </div>
            <h4>{{ $roundedAvg }} / 5 <span>(Overall Rating)</span></h4>
            <span>Based on {{ $totalReviews }} {{ Str::plural('Comment', $totalReviews) }}</span>
        </div>

        @forelse($product_detail->getReview as $data)
            <!-- Single Rating -->
            <div class="single-rating">
                <div class="rating-author">
                    <img src="{{ optional($data->user_info)->photo
            ? asset(optional($data->user_info)->photo)
            : asset('backend/img/avatar.png') }}" 
                        alt="user photo">
                </div>

                <div class="rating-des">
                    <h6>{{ optional($data->user_info)->name ?? 'Anonymous' }}</h6>
                    <div class="ratings">
                        <ul class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <li><i class="fa {{ $data->rate >= $i ? 'fa-star' : 'fa-star-o' }}"></i></li>
                            @endfor
                        </ul>
                        <div class="rate-count">(<span>{{ $data->rate }}</span>)</div>
                    </div>
                    <p>{{ $data->review }}</p>
                </div>
            </div>
            <!--/ End Single Rating -->
        @empty
            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
        @endforelse
    </div>

                    {{-- =================== Add Review Form =================== --}}
                    <div class="comment-review mt-5">
                        <div class="add-review">
                            <h5>Add A Review</h5>
                            <p>Your email address will remain confidential. Fields marked with an asterisk (*) are required.</p>
                        </div>

                        <h4>Your Rating <span class="text-danger">*</span></h4>
                        <div class="review-inner">
                            @auth
                                <form class="form" method="post" action="{{ route('review.store', $product_detail->slug) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="rating_box">
                                                <div class="star-rating">
                                                    <div class="star-rating__wrap">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input class="star-rating__input" id="star-rating-{{ $i }}" type="radio" name="rate" value="{{ $i }}">
                                                            <label class="star-rating__ico fa fa-star-o" for="star-rating-{{ $i }}" title="{{ $i }} out of 5 stars"></label>
                                                        @endfor
                                                        @error('rate')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label>Write a review</label>
                                                <textarea name="review" rows="6" placeholder=""></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-12">
                                            <div class="form-group button5">
                                                <button type="submit" class="btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <p class="text-center p-5">
                                    You need to <a href="{{ route('login.form') }}" style="color:rgb(54, 54, 204)">Login</a> 
                                    OR <a style="color:blue" href="{{ route('register.form') }}">Register</a>
                                </p>
                            @endauth
                        </div>
                    </div>
                    {{-- =================== / End Review Form =================== --}}

                </div>
            </div>
        </div>
    </div>
    <!--/ End Reviews Tab -->





                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </section>
            <!--/ End Shop Single -->


            <!-- Start Most Popular -->
        <div class="product-area most-popular related-product section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2>Related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- {{$product_detail->rel_prods}} --}}
                    <div class="col-12">
                        <div class="owl-carousel popular-slider">
                            @foreach($product_detail->rel_prods as $data)
                                @if($data->id !== $product_detail->id)
                                    <!-- Start Single Product -->
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="{{route('product-detail', $data->slug)}}">
                                                @php 
                                                    $photo = explode(',', $data->photo);
                                                @endphp
                                                <!-- <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}"> -->
                                                <img class="default-img" src="{{ asset($photo[0]) }}" alt="product image">
                                                <img class="hover-img" src="{{ asset($photo[0]) }}" alt="product image">

                                                <span class="price-dec">{{$data->discount}} % Off</span>
                                                                        {{-- <span class="out-of-stock">Hot</span> --}}
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action">
                                                    <a data-toggle="modal" data-target="#modelExample" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                    <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                    <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                                                </div>
                                                <div class="product-action-2">
                                                    <a title="Add to cart" href="#">Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="{{route('product-detail', $data->slug)}}">{{$data->title}}</a></h3>
                                            <div class="product-price">
                                                @php 
                                                    $after_discount = ($data->price - (($data->discount * $data->price) / 100));
                                                @endphp
                                                <span class="old">₱ {{number_format($data->price, 2)}}</span>
                                                <span>₱ {{number_format($after_discount, 2)}}</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Most Popular Area -->


      <!-- Modal -->
      <div class="modal fade" id="modelExample" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <!-- Product Slider -->
                                <div class="product-gallery">
                                    <div class="quickview-slider-active">
                                        <div class="single-slider">
                                            <img src="images/modal1.png" alt="#">
                                        </div>
                                        <div class="single-slider">
                                            <img src="images/modal2.png" alt="#">
                                        </div>
                                        <div class="single-slider">
                                            <img src="images/modal3.png" alt="#">
                                        </div>
                                        <div class="single-slider">
                                            <img src="images/modal4.png" alt="#">
                                        </div>
                                    </div>
                                </div>
                            <!-- End Product slider -->
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>Flared Shift Dress</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="#"> (1 customer review)</a>
                                    </div>
                                    <div class="quickview-stock">
                                        <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                    </div>
                                </div>
                                <h3>$29.00</h3>
                                <div class="quickview-peragraph">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam.</p>
                                </div>

                                <div class="quantity">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="qty" class="input-number"  data-min="1" data-max="1000" value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn">Add to cart</a>
                                    <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                    <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

@endsection
@push('styles')
    <style>
        /* Rating */
        .rating_box {
        display: inline-flex;
        }

        .star-rating {
        font-size: 0;
        padding-left: 10px;
        padding-right: 10px;
        }

        .star-rating__wrap {
        display: inline-block;
        font-size: 1rem;
        }

        .star-rating__wrap:after {
        content: "";
        display: table;
        clear: both;
        }

        .star-rating__ico {
        float: right;
        padding-left: 2px;
        cursor: pointer;
        color: #996EF8;
        font-size: 16px;
        margin-top: 5px;
        }

        .star-rating__ico:last-child {
        padding-left: 0;
        }

        .star-rating__input {
        display: none;
        }

        .star-rating__ico:hover:before,
        .star-rating__ico:hover ~ .star-rating__ico:before,
        .star-rating__input:checked ~ .star-rating__ico:before {
        content: "\F005";
        }

    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

@endpush