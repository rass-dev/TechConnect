<!-- Start Footer Area -->
<footer class="footer">
	<div class="footer-top section">
		<div class="container">
			<div class="row footer-row">
				<div class="col-lg-4 col-md-6 col-12 footer-brand-col">
					<div class="footer-brand">
						<div class="footer-brand-box">
							<img src="{{ asset('images/logo.png') }}" alt="TechConnect" class="footer-logo-img">
							<span class="footer-brand-name">Tech<span class="footer-brand-accent">Connect</span></span>
						</div>
						<p class="footer-about-text">
							Your trusted destination for premium PC components, peripherals, and gadget accessories — secure checkout and fast delivery.
						</p>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-6">
					<div class="single-footer links">
						<h4>Information</h4>
						<ul>
							<li><a href="{{ route('about-us') }}">About Us</a></li>
							<li><a href="{{ route('contact') }}">Contact Us</a></li>
							<li><a href="{{ route('product-grids') }}">Shop</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-6">
					<div class="single-footer links">
						<h4>Customer Service</h4>
						<ul>
							<li><a href="javascript:void(0)" class="tc-service-link" data-service="payment" data-toggle="modal" data-target="#customerServiceModal">Payment Methods</a></li>
							<li><a href="javascript:void(0)" class="tc-service-link" data-service="shipping" data-toggle="modal" data-target="#customerServiceModal">Shipping</a></li>
							<li><a href="javascript:void(0)" class="tc-service-link" data-service="privacy" data-toggle="modal" data-target="#customerServiceModal">Privacy Policy</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<div class="single-footer social">
						<h4>Connect With Us</h4>
						<ul class="footer-contact-list">
							<li><i class="fa fa-map-marker"></i><span>Congressional Rd Ext, Caloocan, Metro Manila</span></li>
							<li><i class="fa fa-envelope"></i><span>support@techconnect.com</span></li>
							<li><i class="fa fa-phone"></i><span>+63 912 345 6789</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<p>&copy; {{ date('Y') }} TechConnect. All rights reserved.</p>
		</div>
	</div>
</footer>
<!-- /End Footer Area -->

<!-- Customer Service Modal -->
<div class="modal fade tc-service-modal" id="customerServiceModal" tabindex="-1" role="dialog" aria-labelledby="customerServiceModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="tc-service-modal-title-wrap">
					<div class="tc-service-modal-icon" id="customerServiceModalIcon"><i class="fa fa-credit-card"></i></div>
					<div>
						<h5 class="modal-title" id="customerServiceModalLabel">Payment Methods</h5>
						<p class="tc-service-modal-sub" id="customerServiceModalSub">How you can pay at TechConnect</p>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="tc-service-panel" data-panel="payment">
					<ul class="tc-service-list">
						<li><i class="fa fa-mobile"></i><div><strong>GCash &amp; Maya</strong><span>Pay instantly using your e-wallet. Scan the QR code at checkout or enter your registered number.</span></div></li>
						<li><i class="fa fa-credit-card"></i><div><strong>Credit / Debit Card</strong><span>Visa, Mastercard, and local bank cards accepted through our secure payment gateway.</span></div></li>
						<li><i class="fa fa-university"></i><div><strong>Bank Transfer</strong><span>Direct transfer to our BDO / BPI accounts. Upload proof of payment to confirm your order.</span></div></li>
						<li><i class="fa fa-truck"></i><div><strong>Cash on Delivery</strong><span>Available for select Metro Manila areas. A small COD fee may apply.</span></div></li>
					</ul>
				</div>
				<div class="tc-service-panel d-none" data-panel="shipping">
					<ul class="tc-service-list">
						<li><i class="fa fa-clock-o"></i><div><strong>Processing Time</strong><span>Orders are packed within 1–2 business days after payment confirmation.</span></div></li>
						<li><i class="fa fa-map-marker"></i><div><strong>Metro Manila</strong><span>Standard delivery: 2–4 business days. Express same-day available in select areas.</span></div></li>
						<li><i class="fa fa-globe"></i><div><strong>Provincial Delivery</strong><span>Luzon, Visayas &amp; Mindanao via courier partners. ETA 5–10 business days.</span></div></li>
						<li><i class="fa fa-gift"></i><div><strong>Free Shipping</strong><span>Enjoy free shipping on orders ₱2,500 and above within Metro Manila.</span></div></li>
					</ul>
				</div>
				<div class="tc-service-panel d-none" data-panel="privacy">
					<div class="tc-service-policy">
						<p>At TechConnect, we respect your privacy and are committed to protecting your personal information.</p>
						<h6>Information We Collect</h6>
						<p>We collect only the details needed to process orders — name, email, phone, shipping address, and payment references.</p>
						<h6>How We Use Your Data</h6>
						<p>Your information is used solely for order fulfillment, customer support, and service improvements. We never sell your data to third parties.</p>
						<h6>Security</h6>
						<p>All transactions are encrypted. Access to customer records is restricted to authorized staff only.</p>
						<h6>Your Rights</h6>
						<p>You may request access, correction, or deletion of your personal data by contacting <a href="mailto:support@techconnect.com">support@techconnect.com</a>.</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="{{ route('contact') }}" class="btn tc-service-contact-btn">Contact Support</a>
				<button type="button" class="btn tc-service-close-btn" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

	<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
	<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('frontend/js/colors.js') }}"></script>
	<script src="{{ asset('frontend/js/slicknav.min.js') }}"></script>
	<script src="{{ asset('frontend/js/owl-carousel.js') }}"></script>
	<script src="{{ asset('frontend/js/magnific-popup.js') }}"></script>
	<script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
	<script src="{{ asset('frontend/js/finalcountdown.min.js') }}"></script>
	<script src="{{ asset('frontend/js/nicesellect.js') }}"></script>
	<script src="{{ asset('frontend/js/flex-slider.js') }}"></script>
	<script src="{{ asset('frontend/js/scrollup.js') }}"></script>
	<script src="{{ asset('frontend/js/onepage-nav.min.js') }}"></script>
	<script src="{{ asset('frontend/js/isotope/isotope.pkgd.min.js') }}"></script>
	<script src="{{ asset('frontend/js/easing.js') }}"></script>
	<script src="{{ asset('frontend/js/active.js') }}"></script>
	<script src="{{ asset('frontend/js/tc-actions.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	@stack('scripts')
	<script>
		setTimeout(function(){ $('.alert').slideUp(); }, 5000);
		var tcServiceContent = {
			payment: { title: 'Payment Methods', sub: 'How you can pay at TechConnect', icon: 'fa-credit-card' },
			shipping: { title: 'Shipping Information', sub: 'Delivery times and coverage areas', icon: 'fa-truck' },
			privacy: { title: 'Privacy Policy', sub: 'How we protect your personal data', icon: 'fa-lock' }
		};
		$('.tc-service-link').on('click', function() {
			var key = $(this).data('service');
			var data = tcServiceContent[key] || tcServiceContent.payment;
			$('#customerServiceModalLabel').text(data.title);
			$('#customerServiceModalSub').text(data.sub);
			$('#customerServiceModalIcon i').attr('class', 'fa ' + data.icon);
			$('.tc-service-panel').addClass('d-none');
			$('.tc-service-panel[data-panel="' + key + '"]').removeClass('d-none');
		});

		$(function() {
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();
				$(this).siblings().toggleClass("show");
				if (!$(this).next().hasClass('show')) {
					$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
			});
		});
	</script>
