@extends('layouts.masterLayout')

@section('html_title', 'Research ME / TE')

@section('page_content')

{!! \Form::open() !!}

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header ">
        <h3 class="box-title">Select Blueprint and Properties</h3>
        <div class="box-tools">&nbsp;</div>
      </div>
      <div class="box-body">
        <div class="form-group row">
          <div class="col-md-1">
            <label for="type">Blueprint</label>
          </div>
          <div class="col-md-11"> 
            {!! \Form::text('type', null, array('autocomplete' => 'off', 'id' => 'type', 'class' => 'form-control select2-input')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-1">
            <label for="system">System</label>
          </div>
          <div class="col-md-11"> 
            {!! \Form::text('system', null, array('autocomplete' => 'off', 'id' => 'system', 'class' => 'form-control select2-input')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-1">
            <label for="me">ME</label>
          </div>
          <div class="col-md-11"> 
            <div class="margin">{!! \Form::text('me', null ,array('autocomplete' => 'off', 'id'=>'me-slider', 'class'=>'slider form-control', 'value'=>'0', 'data-slider-min'=>'0', 'data-slider-max'=>'10', 'data-slider-step'=>'1', 'data-slider-value'=>'[0,10]', 'data-slider-id'=>'green')) !!}</div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-1">
            <label for="te">TE</label>
          </div>
          <div class="col-md-11"> 
            <div class="margin">{!! \Form::text('te', null ,array('autocomplete' => 'off', 'id'=>'te-slider', 'class'=>'slider form-control', 'value'=>'0', 'data-slider-min'=>'0', 'data-slider-max'=>'20', 'data-slider-step'=>'2', 'data-slider-value'=>'[0,20]', 'data-slider-id'=>'green')) !!}</div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-1">
            <label for="laboratory">Laboratory</label>
          </div>
          <div class="col-md-11"> 
            {!! \Form::select('laboratory', array('0'=>'Station', '1' => 'Research Laboratory (ME/TE)', '2' => 'Hyasoda Research Laboratory (ME/TE)'), 'Station', array('autocomplete' => 'off', 'id'=>'laboratory', 'class'=>'form-control', 'value'=>'0')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-1">
            <label for="skills">Character</label>
          </div>
          <div class="col-md-11"> 
            {!! \Form::select('character', $characters, '', array('autocomplete' => 'off', 'id'=>'character', 'class'=>'form-control', 'value'=>'0')) !!}
          </div>
        </div>
      </div>
      <div class="box-footer">
        {!! \Form::submit() !!}
      </div>
    </div>
  </div>
</div>

{!! \Form::close() !!}

@stop

@section('javascript')
<script type="text/javascript">

$('#me-slider').slider({
  formatter: function(value) {
    return 'Current value: ' + value;
  }
});

$('#te-slider').slider({
  formatter: function(value) {
    return 'Current value: ' + value;
  }
});

// List of Items
$('#type').select2({
  placeholder: "Select a Item...",
  minimumInputLength: 3,
    initSelection: function(element, callback) {
      var id = $(element).val();
      if (id !== "") {
          $.ajax("{!! URL::action('AjaxController@getTypeById') !!}?q=" + id, {
              dataType: "json"
          }).done(function(data) { callback(data); });
      }
  },
  ajax: {
    url: "{!! URL::action('AjaxController@getTypes') !!}",
    dataType: 'json',
    data: function (term, page) {
      return {
        q: term
      };
    },
    results: function (data, page) {
      return { results: data };
    }
  }
});

// List of Systems
$('#system').select2({
  placeholder: "Select a System...",
  minimumInputLength: 3,
  initSelection: function(element, callback) {
      var id = $(element).val();
      if (id !== "") {
          $.ajax("{!! URL::action('AjaxController@getSystemById') !!}?q=" + id, {
              dataType: "json"
          }).done(function(data) { callback(data); });
      }
  },
  ajax: {
    url: "{!! URL::action('AjaxController@getSystems') !!}",
    dataType: 'json',
    data: function (term, page) {
      return {
        q: term
      };
    },
    results: function (data, page) {
      return { results: data };
    }
  }
});

// List of laboratorys
$('#laboratory').select2();
// List of Characters
$('#character').select2();

</script>
@stop
