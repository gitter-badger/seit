@extends('layouts.masterLayout')
@section('html_title', 'Market Price Index')
@section('page_content')

<div class="row">
  <div class="col-md-4">
    <!-- results box -->
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title" id="result-box-title">Market Groups</h3>
      </div>
      <div class="box-body">
        <div id="tree">Loading</div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- ./col-md-12 -->
</div><!-- ./row -->


@stop

@section('javascript')

<script src="{{ URL::asset('plugins/jstree/tree.jquery.js') }}" type="text/javascript"></script>
<script type="text/javascript"> 
$.getJSON(
    '{{ URL::action('AjaxController@getMarketgroupTree') }}',
    function(treedata) {
        $('#tree').tree({
            data: treedata
        });
    }
);
</script>
@stop
