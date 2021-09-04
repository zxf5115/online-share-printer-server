<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $response['web_chinese_name'] }}</title>
    <meta name="keywords" content="{{ $response['keywords'] }}">
    <meta name="description" content="{{ $response['description'] }}" />
</head>

<body>
  <div id="app">
      <app></app>
  </div>
</body>
