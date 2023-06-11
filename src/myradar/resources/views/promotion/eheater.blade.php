<!DOCTYPE html>
<html lang="en">

<head>
	<title>e-Heater | myRADAR</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="My Radar">
  <meta name="keywords" content="Radar, Car, Vehicle, Tracking">
  <meta name="author" content="HyperSystems">
	{{-- <link rel="icon" type="image/png" href="{{ asset('bikroy/images/icons/favicon.ico') }}" /> --}}
	<!-- Favicons -->
	<link rel="shortcut icon" href="{{ asset('images/favicon.ico', $hasHttps) }}">
	<link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png', $hasHttps) }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png', $hasHttps) }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png', $hasHttps) }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/bootstrap/css/bootstrap.min.css', $hasHttps) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/fonts/font-awesome-4.7.0/css/font-awesome.min.css', $hasHttps) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/animate/animate.css', $hasHttps) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/css-hamburgers/hamburgers.min.css', $hasHttps) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/select2/select2.min.css', $hasHttps) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/css/util.css', $hasHttps) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/css/main.css', $hasHttps) }}">
	<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

	<div class="bg-contact100" style="background-image: url('/bikroy/images/bg-01.jpg');">
		<div class="container-contact100">
			<div class="wrap-contact100" style="padding-left: 0px; padding-right: 0;">
				<div class="w-full flex flex-col md:flex-row">

					<div class="w-full md:w-1/2 px-12">
						<div class="flex flex-col">
							<div class="w-full flex flex-row justify-start items-center">
								<img src="{{asset('images/web_logo.png', $hasHttps)}}" alt="myRADAR" class="w-auto h-24 md:h-32" />
								<img src="{{asset('images/e-heater.jpg', $hasHttps)}}" alt="e-Heater" class="w-auto h-16 md:h-24 ml-4 md:ml-12 rounded" />
							</div>
							<div class="w-full">
								<p class="mt-2">
									এই শীতে আপনি কি গাড়ির ইঞ্জিন ঠান্ডা হয়ে যাওয়ার সমস্যায় ভুগছেন? <br>
									করনার কারনে ড্রাইভার নাই, তাই প্রতিদিন সকালে গাড়ির ইঞ্জিন গরম করতে গিয়ে আপনার কি অফিসে যাওয়ার সময়
									বিড়ম্বনা হচ্ছে? <br>
									এই সমস্যা থেকে মুক্তি দিতে মাইরাডার নিয়ে এলো "ই-হিটার"। <br><br>

									ই-হিটার দিয়ে ঘরে বসেই মোবাইল অ্যাপ থেকে গাড়ির ইঞ্জিন অন করে ইঞ্জিন গরম করে নিন। সেই সাথে গাড়ির
									ব্যাটারী চার্জ করে নিন। <br><br>

									ই-হিটারের সুবিধাসমূহঃ <br>
								</p>
								<ul class="text-gray-700" style="list-style-type: none;">
									<li><i class="fa fa-caret-right"></i> মোবাইল App এর মাধ্যমে গাড়ির ইঞ্জিন চালু হবে</li>
									<li><i class="fa fa-caret-right"></i> দ্রুতগতিতে গাড়ির ইঞ্জিন হবে গরম</li>
									<li><i class="fa fa-caret-right"></i> ব্যাটারি হবে চার্জড</li>
									<li><i class="fa fa-caret-right"></i> বারবার ব্যাটারি বসে যাওয়ার সমস্যার সমাধান</li>
									<li><i class="fa fa-caret-right"></i> দীর্ঘসময় গ্যারেজে গাড়ি বসে থাকলেও ব্যাটারী থাকবে সচল</li>
									<li><i class="fa fa-caret-right"></i> সময় সাশ্রয়ী ডিজিটাল সমাধান</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="w-full md:w-1/2 mt-12 md:mt-0 flex flex-row justify-center px-8">
						@if ($status == 1)
						<h2 class="text-success"><strong>We will contact you soon</strong></h2>
						@else
						<form class="contact100-form validate-form" action="/enroll/save" method="post">
							{!! csrf_field() !!}
							<span class="contact100-form-title text-center">
								To Get 2000 Taka Discount register now
							</span>

							<div class="wrap-input100 validate-input" data-validate="Name is required">
								<input class="input100" type="text" name="name" placeholder="Name">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-user" aria-hidden="true"></i>
								</span>
							</div>

							<div class="wrap-input100 validate-input" data-validate="Phone number required">
								<input class="input100" type="text" name="phone" placeholder="Mobile Number">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-phone" aria-hidden="true"></i>
								</span>
							</div>

							<div class="wrap-input100">
								<input class="input100" type="text" name="email" placeholder="Email Address">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</span>
							</div>

							<div class="container-contact100-form-btn">
								<button class="contact100-form-btn">
									Send
								</button>
							</div>
							<div class="container-contact100-form-btn">
								<span class="contact100-form-title text-center">For details please call: 01907888839</span>
							</div>
						</form>
						@endif
					</div>

				</div>
			</div>
		</div>
	</div>

	<script src="{{ asset('bikroy/vendor/jquery/jquery-3.2.1.min.js', $hasHttps) }}"></script>
	<script src="{{ asset('bikroy/vendor/bootstrap/js/popper.js', $hasHttps) }}"></script>
	<script src="{{ asset('bikroy/vendor/bootstrap/js/bootstrap.min.js', $hasHttps) }}"></script>
	<script src="{{ asset('bikroy/vendor/select2/select2.min.js', $hasHttps) }}"></script>
	<script src="{{ asset('bikroy/vendor/tilt/tilt.jquery.min.js', $hasHttps) }}"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="{{ asset('bikroy/js/main.js', $hasHttps) }}"></script>

</body>

</html>
