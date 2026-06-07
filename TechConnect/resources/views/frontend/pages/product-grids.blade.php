@extends('frontend.layouts.master')

@section('title','TechConnect | Product Page')

@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="{{ route('product-grids') }}">Shop</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    
    <!-- Product Style -->
    <form action="{{route('shop.filter')}}" method="POST">
        @csrf
        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">

									<div class="single-widget range">
										<h3 class="title">Price Range</h3>
										<div class="price-filter">
											<div class="price-filter-inner">
												<div class="product_filter d-flex align-items-center">
													<input type="number" name="min_price" class="form-control"
														value="{{ request()->get('min_price') }}"
														min="0" placeholder="Min ₱" style="flex:1;">
													<input type="number" name="max_price" class="form-control"
														value="{{ request()->get('max_price') }}"
														min="0" placeholder="Max ₱" style="flex:1;">
													<button type="submit" class="btn-filter" aria-label="Apply filter">
														<i class="fa fa-search"></i>
													</button>
												</div>
											</div>
										</div>
									</div>
									<!--/ End Shop By Price -->

                                <!-- Single Widget -->
                                <div class="single-widget category">
                                    <h3 class="title">Categories</h3>
                                    <ul class="categor-list">
										@php
											// $category = new Category();
											$menu=App\Models\Category::getAllParentWithChild();
										@endphp
										@if($menu)
										<li>
											@foreach($menu as $cat_info)
													@if($cat_info->child_cat->count()>0)
														<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
															<ul>
																@foreach($cat_info->child_cat as $sub_menu)
																	<li><a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
																@endforeach
															</ul>
														</li>
													@else
														<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
													@endif
											@endforeach
										</li>
										@endif

                                    </ul>
                                </div>
                                <!--/ End Single Widget -->

                            
                                <!--/ End Single Widget -->
                                <!-- Single Widget -->
                                <div class="single-widget category">
                                    <h3 class="title">Brands</h3>
                                    <ul class="categor-list">
                                        @php
                                            $brands=DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
                                        @endphp
                                        @foreach($brands as $brand)
                                            <li><a href="{{route('product-brand',$brand->slug)}}">{{$brand->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="shop-page-header">
                            @if(!empty($search_query))
                                <h1>Search Results for "{{ $search_query }}"</h1>
                            @else
                                <h1>All Products</h1>
                            @endif
                            <p>{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                    <span style="font-size:14px; color:var(--tc-text-muted); font-weight:500;">
                                        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                                    </span>
                                    <ul class="view-mode">
                                        <li class="active"><a href="javascript:void(0)" title="Grid view"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href="{{route('product-lists')}}" title="List view"><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        <div class="row">
                            {{-- {{$products}} --}}
                            @if(count($products)>0)
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('product-detail',$product->slug)}}">
                                                    @php
                                                        $photos = array_filter(explode(',', $product->photo));
                                                        $imgSrc = !empty($photos) ? asset(trim($photos[0])) : asset('images/logo.png');
                                                    @endphp
                                                    <div class="product-image-container">
                                                        <img class="product-image default-img" src="{{ $imgSrc }}" alt="{{$product->title}}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                                                        @if($product->discount)
                                                            <span class="price-dec">{{$product->discount}} % Off</span>
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                                @php
                                                    $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                                @endphp
                                                <div class="product-price">
                                                    <span>₱ {{ number_format($after_discount, 2) }}</span>
                                                    @if($product->discount)
                                                        <span class="old">₱ {{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="product-card-actions">
                                                    <a class="pca-icon" data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class="ti-eye"></i></a>
                                                    <a class="pca-icon wishlist" title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" data-id="{{$product->id}}"><i class="ti-heart"></i></a>
                                                    <a class="pca-cart" title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="empty-state">
                                        <i class="fa fa-shopping-bag"></i>
                                        <h4>No products found</h4>
                                        <p style="color:var(--tc-text-muted); margin-top:8px;">Try adjusting your filters or browse all categories.</p>
                                        <a href="{{ route('product-grids') }}" class="btn-modern" style="margin-top:16px; display:inline-flex;">View All Products</a>
                                    </div>
                                </div>
                            @endif
                            

                           
                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{$products->appends($_GET)->links()}} 
                            </div>
                          </div>

                    </div>
                </div>
            </div>
        </section>
    </form>
   
    <!--/ End Product Style 1  -->	
  
    
    
    <!-- Modal -->
    @if($products)
        @foreach($products as $key=>$product)
            <div class="modal fade product-quickview" id="{{$product->id}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row no-gutters">
                                    <div class="col-lg-6 col-md-12 qv-image-col">
                                        <div class="product-gallery">
                                            <div class="quickview-image-active quickview-slider-active">
                                                @php $photos = array_filter(explode(',', $product->photo)); @endphp
                                                @foreach($photos as $data)
                                                    <div class="single-slider">
                                                        <img src="{{ asset(trim($data)) }}" alt="{{$product->title}}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="quickview-content">
                                            <h2>{{$product->title}}</h2>
                                            <div class="quickview-ratting-review">
                                                <div class="quickview-ratting-wrap">
                                                    <div class="quickview-ratting">
                                                        @php
                                                            $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                            $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                        @endphp
                                                        @for($i=1; $i<=5; $i++)
                                                            @if($rate>=$i)
                                                                <i class="yellow fa fa-star"></i>
                                                            @else 
                                                            <i class="fa fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <a href="#"> ({{$rate_count}} customer review)</a>
                                                </div>
                                                <div class="quickview-stock">
                                                    @if($product->stock >0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                    @else 
                                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                                $after_discount=($product->price-($product->price*$product->discount)/100);
                                            @endphp
                                            <h3><small><del class="text-muted">₱ {{number_format($product->price,2)}}</del></small>    ₱ {{number_format($after_discount,2)}}  </h3>
                                            <div class="quickview-peragraph">
                                                <p>{!! html_entity_decode($product->summary) !!}</p>
                                            </div>
                                            @if($product->size)
                                                <div class="size">
                                                    <h4>Size</h4>
                                                    <ul>
                                                        @php 
                                                            $sizes=explode(',',$product->size);
                                                            // dd($sizes);
                                                        @endphp
                                                        @foreach($sizes as $size)
                                                        <li><a href="#" class="one">{{$size}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <form action="{{route('single-add-to-cart')}}" method="POST" class="qv-actions">
                                                @csrf
                                                <div class="quantity">
                                                    <div class="input-group">
                                                        <div class="button minus">
                                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="slug" value="{{$product->slug}}">
                                                        <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                                        <div class="button plus">
                                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                                <i class="ti-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="add-to-cart">
                                                    <button type="submit" class="btn">Add to Cart</button>
                                                    <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min" title="Add to Wishlist"><i class="ti-heart"></i></a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
    
@endsection
@push('styles')
<style>
    .pagination{
        display:inline-flex;
    }
    .filter_button{
        /* height:20px; */
        text-align: center;
        background:#996EF8;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }
            
            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
@endpush