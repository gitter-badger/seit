@extends('layouts.masterLayout')

@section('html_title', 'Manufacture')

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
          <div class="col-md-2">
            <label for="type">Blueprint</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('type', null, array('autocomplete' => 'off', 'id' => 'type', 'class' => 'form-control select2-input')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="system">System</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('system', null, array('autocomplete' => 'off', 'id' => 'system', 'class' => 'form-control select2-input')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="me">ME</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('me', null ,array('autocomplete' => 'off', 'id'=>'me-slider', 'class'=>'form-control', 'value'=>'0')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="te">TE</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('te', null ,array('autocomplete' => 'off', 'id'=>'te-slider', 'class'=>'form-control', 'value'=>'0')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="te">Quantity</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('qty', null ,array('autocomplete' => 'off', 'id'=>'qty', 'class'=>'form-control', 'value'=>'0')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="assembly">Assembly</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::select('assembly', array('0'=>'Station', '1' => 'Assembly Array', '2' => 'Thukker Assembly Array', '3' => 'Rapid Assembly Array'), 'Station', array('autocomplete' => 'off', 'id'=>'assembly', 'class'=>'form-control', 'value'=>'0')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="skills">Character</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::select('character', $characters, '', array('autocomplete' => 'off', 'id'=>'character', 'class'=>'form-control', 'value'=>'0')) !!}
          </div>
        </div>
      </div>
      <div class="box-footer">
        {!! \Form::submit() !!}
      </div>
    </div>
  </div>
<div>

{!! \Form::close() !!}

@stop

@section('javascript')
<script type="text/javascript">

$('#me-slider').TouchSpin({
  min: 0,
  max: 10,
  step: 1,
  initval: 0,
  verticalbuttons: true,
  verticalupclass: 'glyphicon glyphicon-plus',
  verticaldownclass: 'glyphicon glyphicon-minus'
});

$('#te-slider').TouchSpin({
  min: 0,
  max: 20,
  step: 2,
  initval: 0,
  verticalbuttons: true,
  verticalupclass: 'glyphicon glyphicon-plus',
  verticaldownclass: 'glyphicon glyphicon-minus'
});

$("#qty").TouchSpin({
  initval: 0,
  verticalbuttons: true,
  verticalupclass: 'glyphicon glyphicon-plus',
  verticaldownclass: 'glyphicon glyphicon-minus'
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

// List of Assemblys
$('#assembly').select2();
// List of Characters
$('#character').select2();

</script>
@stop
