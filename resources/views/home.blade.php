<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Currency rate</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    {{-- Styles --}}
    <link rel="stylesheet" type="text/css" href="css/app.css">

</head>
<body>
<div id="currency-app">
    <currency-component></currency-component>
    <market-component></market-component>
</div>

<script src="js/app.js"></script>
</body>
</html>