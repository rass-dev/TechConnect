@extends('frontend.layouts.master')

@section('title', 'TechConnect | Contact Us')

@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="bread-inner">
				<ul class="bread-list">
					<li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
					<li class="active"><a href="javascript:void(0);">Contact</a></li>
				</ul>
			</div>
		</div>
	</div>

	<!-- Contact Page -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
			<div class="contact-page-header text-center">
				<h1>Get in Touch</h1>
				<p>Have a question? Our support team is ready to help you.</p>
			</div>

			<div class="row g-4">
				<!-- Contact Form -->
				<div class="col-lg-5">
					<div class="contact-card contact-card-form">
						<div class="contact-card-head">
							<h3>Contact Support</h3>
							<p class="contact-card-sub">Fill out the form and we'll get back to you shortly.</p>
						</div>
						<form id="contactForm" action="{{ route('contact.store') }}" method="POST">
							@csrf
							<div class="row g-3">
								<div class="col-md-6">
									<div class="form-field @error('name') has-error @enderror">
										<label for="contact-name">Your Name <span class="req">*</span></label>
										<input id="contact-name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" maxlength="80" value="{{ old('name') }}">
										@error('name')<span class="field-error" role="alert">{{ $message }}</span>@enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-field @error('subject') has-error @enderror">
										<label for="contact-subject">Your Subject <span class="req">*</span></label>
										<input id="contact-subject" name="subject" type="text" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter subject" maxlength="100" value="{{ old('subject') }}">
										@error('subject')<span class="field-error" role="alert">{{ $message }}</span>@enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-field @error('email') has-error @enderror">
										<label for="contact-email">Your Email <span class="req">*</span></label>
										<input id="contact-email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address" maxlength="120" value="{{ old('email') }}">
										@error('email')<span class="field-error" role="alert">{{ $message }}</span>@enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-field @error('phone') has-error @enderror">
										<label for="contact-phone">Your Phone <span class="req">*</span></label>
										<input id="contact-phone" name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter your phone" maxlength="15" value="{{ old('phone') }}">
										@error('phone')<span class="field-error" role="alert">{{ $message }}</span>@enderror
									</div>
								</div>
								<div class="col-12">
									<div class="form-field @error('message') has-error @enderror">
										<label for="contactMessage">Your Message <span class="req">*</span></label>
										<textarea name="message" id="contactMessage" class="form-control contact-message-box @error('message') is-invalid @enderror" rows="4" placeholder="How can we help you? (max 200 characters)" maxlength="200">{{ old('message') }}</textarea>
										<div class="contact-message-meta">
											<span class="contact-message-hint">Minimum 20 characters</span>
											<span class="contact-char-count"><span id="contactCharCount">0</span>/200</span>
										</div>
										@error('message')<span class="field-error" role="alert">{{ $message }}</span>@enderror
									</div>
								</div>
								<div class="col-12 contact-submit-wrap">
									<button type="submit" class="btn-contact-submit w-100">Send Message</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Map + Info -->
				<div class="col-lg-7">
					<div class="contact-card contact-card-map h-100">
						<div class="contact-map">
							<iframe
								src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.5!2d120.9822!3d14.6501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b61b1c2c8f0d%3A0x8c8d8b8b8b8b8b8b!2sCongressional%20Rd%20Ext%2C%20Caloocan%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1692700000000"
								width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
								referrerpolicy="no-referrer-when-downgrade" title="TechConnect location">
							</iframe>
						</div>
						<div class="contact-info-grid">
							<div class="contact-info-item">
								<div class="contact-info-icon"><i class="fa fa-phone"></i></div>
								<h4>Call Us</h4>
								<p>+63 912 345 6789</p>
							</div>
							<div class="contact-info-item">
								<div class="contact-info-icon"><i class="fa fa-envelope"></i></div>
								<h4>Email</h4>
								<p><a href="mailto:support@techconnect.com">support@techconnect.com</a></p>
							</div>
							<div class="contact-info-item">
								<div class="contact-info-icon"><i class="fa fa-map-marker"></i></div>
								<h4>Address</h4>
								<p>Congressional Rd Ext,<br>Caloocan, Metro Manila</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Login Required Modal -->
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
			<div class="modal-content contact-login-modal">
				<div class="modal-body text-center p-4">
					<p class="mb-3">Please log in first to send a message.</p>
					<div class="d-flex justify-content-center gap-2">
						<button type="button" class="btn btn-modal-close" data-dismiss="modal">Close</button>
						<a href="{{ route('login.form') }}" class="btn btn-modal-login">Login</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('frontend/js/contact.js') }}"></script>
	<script>
		$(document).ready(function () {
			function updateCharCount() {
				var len = $('#contactMessage').val().length;
				$('#contactCharCount').text(len);
				$('.contact-char-count').toggleClass('at-limit', len >= 200);
			}
			$('#contactMessage').on('input', updateCharCount);
			updateCharCount();
			@if($errors->any())
				$('.form-field.has-error .form-control, .form-field.has-error textarea').addClass('is-invalid');
			@endif

			@guest
				$('#contactForm').on('submit', function (e) {
					e.preventDefault();
					$('#loginModal').modal('show');
				});
			@endguest
		});
	</script>
@endpush
