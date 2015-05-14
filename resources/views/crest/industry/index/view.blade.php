@extends('layouts.masterLayout')

@section('html_title', 'Industry Indexes')

@section('page_content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Select Region:</h3>
      </div>
      <div class="box-body">
        <div class="input-group">
        {!! \Form::open() !!}
          <fieldset>
            {!! \Form::select('regionsMap', $regionsMap, null, array('id' => 'regionsMap', 'class' => 'form-control') ) !!}
          </fieldset>
        {!! \Form::close() !!}
        </div>
      </div><!-- ./box-body -->
    </div><!-- ./box -->
  </div><!-- ./col-md-12 -->
</div><!-- ./row -->
<div class="row">
  <div class="col-md-12">
    <!-- results box -->
    <div class="box box-primary" id="result-box" style="display: none;">
      <div class="box-header">
        <h3 class="box-title" id="result-box-title">Regional System Indexes</h3>
      </div>
  
      <div class="box-body">
        <div id="result">
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- ./col-md-12 -->
</div><!-- ./row -->

@stop

@section('javascript')

<script type="text/javascript">
$('#regionsMap').select2({
  placeholder: "Select a Region",
  width: "350"
});
$('#regionsMap').on('change', function(e) {
      if (e.val.length > 0) { // Don't try and search for nothing
        $("div#result").html("<i class='fa fa-cog fa-spin'></i> Loading...");
        $("div#result-box").fadeIn("slow");
        $.ajax({
          type: 'post',
          url: "{!! \URL::action('CrestDataController@postIndustryRegionalIndexes') !!}",
          data: {
            'regionID': e.val,
            '_token': $('input[name=_token]').val()
          },
          success: function(result){
            $("div#result").html(result);
            $("table#datatable").dataTable({ "paging": false });
          },
          error: function(xhr, textStatus, errorThrown){
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
          }
        });
      }
})
</script>

@stop
