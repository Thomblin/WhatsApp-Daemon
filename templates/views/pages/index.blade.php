@extends('layouts.master')

@section('title', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
    <fieldset>
        <legend>Customers</legend>
        <div id="chat">

        </div>
    </fieldset>
@endsection

@section('js')
    @parent
    <script type="application/javascript" src="js/index.js"></script>
@endsection

@section('css')
    @parent
    <link href="css/chat.css" rel="stylesheet"/>
@endsection
