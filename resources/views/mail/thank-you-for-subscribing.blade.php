<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Subscribing</title>
    <style>
        /* Tailwind CSS CDN */
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100 py-16">
<div class="flex items-center justify-center">
    <img src="https://www.indaygenius.com/photos/inday-logo-bw.svg" alt="Inday Genius Logo" class="w-48 py-6">
</div>
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Thank You for Subscribing!</h1>
    <p class="text-gray-700 mb-4">
        Hi {{ $email }},
    </p>
    <p class="text-gray-700 mb-4">
        Thank you for subscribing to our newsletter. We're excited to have you on board!
    </p>
    <p class="text-gray-700 mb-4">
        You will now receive regular updates on our latest content, news, and special offers directly in your inbox.
    </p>
    {{--    <p class="text-gray-700 mb-4">--}}
    {{--        If you have any questions, feel free to <a href="mailto:info@indaygenius.com"--}}
    {{--                                                   class="text-blue-500 underline">contact--}}
    {{--            us</a>.--}}
    {{--    </p>--}}
    <p class="text-gray-700 mb-4">
        Best regards,<br><br>
        The Inday Genius Team
    </p>
    {{--    <hr class="my-6">--}}
    {{--    <p class="text-gray-600 text-sm">--}}
    {{--        If you did not subscribe to this newsletter, please ignore this email or--}}
    {{--        <a href="#"--}}
    {{--           class="text-blue-500 underline">unsubscribe--}}
    {{--            here</a>.--}}
    {{--    </p>--}}
</div>
</body>
</html>
