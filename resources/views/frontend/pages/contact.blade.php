@extends('frontend.layouts.master')

@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
			<div class="row justify-content-center">

				<!-- Left Side: Contact Form -->
				<div class="col-lg-6 col-md-12 mb-4 mb-lg-0" style="margin-left: -120px;">
					<div class="box card-style h-100">
						<div class="title">
							<h3>Contact Support</h3>
						</div>
						<form id="contactForm">
							<div class="row">
								<!-- Name -->
								<div class="col-md-6 mb-3">
									<div class="form-group">
										<label>Your Name<span>*</span></label>
										<input name="name" type="text" class="form-control" placeholder="Enter your name">
									</div>
								</div>
								<!-- Subject -->
								<div class="col-md-6 mb-3">
									<div class="form-group">
										<label>Your Subject<span>*</span></label>
										<input name="subject" type="text" class="form-control" placeholder="Enter Subject">
									</div>
								</div>

								<!-- Email -->
								<div class="col-md-6 mb-3">
									<div class="form-group">
										<label>Your Email<span>*</span></label>
										<input name="email" type="email" class="form-control"
											placeholder="Enter email address">
									</div>
								</div>
								<!-- Phone -->
								<div class="col-md-6 mb-3">
									<div class="form-group">
										<label>Your Phone<span>*</span></label>
										<input name="phone" type="number" class="form-control"
											placeholder="Enter your phone">
									</div>
								</div>

								<!-- Message (full width) -->
								<div class="col-12 mb-3">
									<div class="form-group message">
										<label>Your Message<span>*</span></label>
										<textarea name="message" class="form-control" cols="30" rows="4"
											placeholder="Enter Message"></textarea>
									</div>
								</div>

								<!-- Button (full width) -->
								<div class="col-12">
									<div class="form-group button">
										<button type="submit" class="btn btn-primary w-100">Send Message</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Right Side: Map + Contact Info -->
				<div class="col-lg-7 col-md-12">
					<div class="box card-style h-100">
						<div class="row g-3 align-items-stretch">
							<!-- Map -->
							<div class="col-12 mb-3">
								<div class="map-box w-100 h-100">
									<iframe
										src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.123456789012!2d120.9822!3d14.6501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c993a1234567%3A0xabcdef1234567890!2sCongressional%20Rd%20Ext%2C%20Caloocan%2C%20Metro%20Manila%2C%20Philippines!5e0!3m2!1sen!2sph!4v1692700000000!5m2!1sen!2sph"
										width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen=""
										aria-hidden="false" tabindex="0">
									</iframe>
								</div>
							</div>

							<!-- Info -->
							<div class="col-12">
								<div class="contact-info-box w-100">
									<div class="row text-center">
										<!-- Phone -->
										<div class="col-md-4 col-12 single-info">
											<i class="fa fa-phone icon"></i>
											<h4 class="title">Call Us</h4>
											<p>+63 912 345 6789</p>
										</div>
										<!-- Email -->
										<div class="col-md-4 col-12 single-info" style="margin-left: -40px;">
											<i class="fa fa-envelope-open icon"></i>
											<h4 class="title">Email</h4>
											<p><a href="mailto:support@techconnect.com">support@techconnect.com</a></p>
										</div>
										<!-- Address -->
										<div class="col-md-4 col-12 single-info" style="margin-left: 40px;">
											<i class="fa fa-location-arrow icon"></i>
											<h4 class="title">Address</h4>
											<p>Q23J+R9M, Congressional Rd Ext,<br>Caloocan, Metro Manila</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!--/ End Contact -->

	<!-- Login Required Modal -->
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body text-center p-4">
					<p class="mb-3">Please log in first to send a message.</p>
					<div class="d-flex justify-content-center gap-2">
						<div class="modal-footer">
							<button type="button" class="btn btn-close-custom" data-bs-dismiss="modal">CLOSE</button>

							<a href="/user/login" class="btn btn-login">LOGIN</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('styles')
	<style>

		/* Style all required field asterisks */
label span {
    color: red;
}


		#contact-us {
			margin-top: -80px;
		}


		/* ===============================
		   Contact Page Primary Button
		================================= */
		#contactForm .btn-primary {
			background: var(--purple) !important;
			border: none !important;
			color: #fff !important;
			font-weight: 500;
			border-radius: 8px !important;
			transition: filter 0.2s ease-in-out;
		}

		#contactForm .btn-primary:hover {
			filter: brightness(0.9);
		}

		#contactForm .btn-primary:active {
			filter: brightness(0.85);
		}

		/* ===============================
		   Login Modal Styles
		================================= */
		#loginModal .modal-dialog {
			max-width: 360px !important;
			margin: auto;
		}

		#loginModal .btn-close-custom,
		#loginModal .btn-login {
			min-width: 110px;
			height: 38px;
			font-size: 14px !important;
			border-radius: 8px !important;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			transition: filter 0.2s ease-in-out;
			border: none;
			color: #fff;
		}

		/* Close button */
		#loginModal .btn-close-custom {
			background: var(--indigo);
		}

		#loginModal .btn-close-custom:hover {
			filter: brightness(0.9);
		}

		#loginModal .btn-close-custom:active {
			filter: brightness(0.85);
		}

		/* Login button */
		#loginModal .btn-login {
			background: var(--purple);
		}

		#loginModal .btn-login:hover {
			filter: brightness(0.9);
		}

		#loginModal .btn-login:active {
			filter: brightness(0.85);
		}

		/* Modal content */
		#loginModal .modal-content {
			border-radius: 12px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
			height: 180px !important;
			display: inline-block;
		}

		#loginModal .modal-body {
			padding: 15px 20px;
			text-align: center;
			display: flex;
			flex-direction: column;
			justify-content: center;
			height: 100%;
		}

		#loginModal .modal-body p {
			font-size: 14px;
			color: #333;
			margin-bottom: 20px;
			line-height: 1.4;
		}

		#loginModal .modal-footer {
			border-top: none;
			padding: 0;
			justify-content: center;
			background: none;
		}

		#loginModal .btn {
			margin: 0 5px;
		}

		/* Centering */
		#loginModal .modal-dialog-centered {
			display: flex;
			align-items: center;
			min-height: calc(100vh - 1rem);
		}

		/* General modal design */
		.modal-content {
			border-radius: 12px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		}

		.modal-body p {
			font-size: 15px;
			color: #333;
		}

		.gap-2>*:not(:last-child) {
			margin-right: 10px;
		}

		/* Reusable Card Style */
		.card-style {
			background: #fff;
			border-radius: 12px;
			padding: 20px;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
		}

		/* ======================================
	   Map Box
	====================================== */
		/* Map box mas malaki */
		.map-box {
			height: 400px;
			/* dati 350px → pinalaki */
			border-radius: 12px;
			overflow: hidden;
		}

		/* Info box mas spacious */
		.contact-info-box {
			padding: 35px 25px;
			border-radius: 12px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
		}

		/* Info items */
		.contact-info-box .single-info {
			padding: 15px 10px;
		}

		.contact-info-box .icon {
			font-size: 32px;
			/* mas malaki icon */
			margin-bottom: 8px;
			color: var(--purple);
		}

		.contact-info-box .title {
			font-size: 17px;
			font-weight: 600;
		}

		.contact-info-box p,
		.contact-info-box a {
			font-size: 15px;
		}
	</style>
@endpush


@push('scripts')
	<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('frontend/js/contact.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		$(document).ready(function () {
			@guest
				// Kapag hindi naka-login, pigilan yung form submit at ipakita modal
				$('#contactForm').on('submit', function (e) {
					e.preventDefault();
					$('#loginModal').modal('show');
				});
			@endguest
			});
	</script>
@endpush