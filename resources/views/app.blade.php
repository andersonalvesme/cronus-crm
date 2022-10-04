<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{settings()->application_name}}</title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <link rel="icon" href="{{ asset('favicon.ico') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
</head>
<body id="bodySystem" class="antialiased">
<div id="root"></div>
</body>
<script type="text/javascript" src="{{lang()}}"></script>
<script>
    window.app = {
        application: {
            date_format: "{{settings()->get('application_date_format')}}"
        },
        currency: {
            code: "{{settings()->get('currency_code')}}",
            precision: "{{settings()->get('currency_precision')}}",
            decimal_separator: "{{settings()->get('decimal_separator')}}",
            thousands_separator: "{{settings()->get('thousands_separator')}}",
            placement: "{{settings()->get('placement')}}"
        },
        links: @json(auth()->user()->topLinks()),
        user: {
            id: {{auth()->id()}},
            name: "{{auth()->user()->name}}"
        }
    };
</script>
<script type="text/javascript" src="{{mix('js/app.js')}}"></script>
</html>
