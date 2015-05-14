@extends('layouts.masterLayout')

@section('html_title', 'DebugView©')

@section('page_content')

        @if(isset($payload))
            <pre>{{{ print_r($payload) }}}</pre>
        @endif

@stop

@section('javascript')

@stop
