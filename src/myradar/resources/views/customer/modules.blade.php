<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Choose Modules | myRADAR</title>

  <!-- Favicons -->
	<link rel="shortcut icon" href="{{ asset('images/favicon.ico', $hasHttps) }}">
	<link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png', $hasHttps) }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png', $hasHttps) }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png', $hasHttps) }}">

  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
  <div class="w-full h-screen bg-blue-600 flex flex-row justify-center items-center space-x-8">
    <a href="/car/tracking" class="w-1/3 flex flex-col items-center justify-center space-y-6 py-6 bg-white rounded-xl shadow-xl hover:bg-gray-100 duration-300">
      <span class="text-gray-600 font-bold text-xl">Fleet Management</span>
      <img src="/images/redcar.svg" class="w-1/2 h-auto" alt="">
    </a>
    <a href="http://rms.myradar.com.bd/login?token={{ session('token') }}" target="_blank" class="w-1/3 flex flex-col items-center justify-center space-y-6 py-6 bg-white rounded-xl shadow-xl hover:bg-gray-100 duration-300">
      <span class="text-gray-600 font-bold text-xl">RMS Site Management</span>
      <img src="/images/industry-40_2.png" class="w-1/2 h-auto" alt="">
    </a>
  </div>
</body>
</html>
