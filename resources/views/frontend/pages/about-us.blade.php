@extends('frontend.layouts.master')

@section('title', 'TechConnect | About Us')

@push('styles')
	<style>
		.about-content .btn-primary {
			background: var(--purple) !important;
			border: none !important;
			color: #fff !important;
			font-weight: 500;
			border-radius: 8px !important;
			padding: 10px 15px;
			transition: filter 0.2s ease-in-out;
		}

		.about-content .btn-primary:hover {
			filter: brightness(0.9);
		}

		.about-content .btn-primary:active {
			filter: brightness(0.85);
		}

		.about-img {
			border-radius: 12px !important;
			overflow: hidden;
			border: none !important;
		}

		.about-img img {
			border-radius: 12px !important;
			display: block;
			width: 100%;
			height: auto;
		}

		.breadcrumbs {
			margin-bottom: 0 !important;
		}

		.about-us.section {
			margin-top: 0 !important;
			padding-top: 40px !important;
		}

		.about-content h3 {
			margin-bottom: 30px !important;
			font-size: 28px;
		}

		.about-content p {
			margin-bottom: 15px !important;
			font-size: 16px;
		}
	</style>
@endpush

@section('main-content')

	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0)">About Us</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="about-us section">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-12">
					<div class="about-content">
						<h3><span>TechConnect</span></h3>
						<p>
							TechConnect provides a seamless online shopping experience for gadget accessories,
							featuring product browsing, secure checkout, and order tracking.
						</p>
						<div class="button">
							<a href="{{ route('contact') }}" class="btn btn-primary">Contact Support</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<div class="about-img">
						<img src="{{ asset('images/logo2.jpg') }}" alt="Logo">
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection