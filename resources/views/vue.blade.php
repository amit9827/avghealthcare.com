<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AVG Healthcare - From Herbal Remedies to Wellness Solutions</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @routes <!-- Required -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <!-- Font Awesome CDN -->
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
integrity="sha512-..."
crossorigin="anonymous"
referrerpolicy="no-referrer"
/>

@verbatim
<!-- Global Organization Schema -->
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "AVG Healthcare",
      "url": "https://www.avghealthcare.com/",
      "logo": "https://www.avghealthcare.com/assets/logo.svg",
      "sameAs": [
        "https://www.facebook.com/AVGHealthcare,
        "https://www.instagram.com/avghealthcare",
        "https://www.youtube.com/c/AVGHealthcare"
      ]
    }
    </script>
@endverbatim

<script>
    window.base_url = "{{ url('/') }}";
</script>

    </head>
    <body>

        <div id="app">
        </div>
    </body>
</html>
