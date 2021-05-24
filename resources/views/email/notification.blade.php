@extends('email.layout')
@section('content')
Hola {{$costumer_name}}.<br />

La Orden #{{$id}} ha cambiado a estado ({{$status}}).
<br><br>
{{$product}}: ${{number_format($price)}}
<br><br>
<div style="padding: 20px; background-color: lightgoldenrodyellow; color: #000;border:1px solid #000;">
    {{$msg}}</div>
<br><br>
<a href="{{$link}}" style="padding: 10px; background-color: #3097D1; color: #fff;">
    Ver Orden</a>
<br>
@endsection
