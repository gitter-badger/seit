@extends('layouts.masterLayout')

@section('html_title', 'Manufacture')

@section('page_content')

{!! \Form::open() !!}
<div class="row">
  <div class="col-md-6">
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
            {!! \Form::text('type', $payload['input']['type'], array('autocomplete' => 'off', 'id' => 'type', 'class' => 'form-control select2-input')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="system">System</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('system', $payload['input']['system'], array('autocomplete' => 'off', 'id' => 'system', 'class' => 'form-control select2-input')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="me">ME</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('me', $payload['input']['me'], array('autocomplete' => 'off', 'id'=>'me-slider', 'class'=>'form-control')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="te">TE</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('te', $payload['input']['te'], array('autocomplete' => 'off', 'id'=>'te-slider', 'class'=>'form-control')) !!}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-2">
            <label for="te">Quantity</label>
          </div>
          <div class="col-md-10"> 
            {!! \Form::text('qty', $payload['input']['qty'] ,array('autocomplete' => 'off', 'id'=>'qty', 'class'=>'form-control', 'value'=>'0')) !!}
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
            {!! \Form::select('character', $payload['characters'], $payload['input']['character'], array('autocomplete' => 'off', 'id'=>'character', 'class'=>'form-control')) !!}
          </div>
        </div>
      </div>
      <div class="box-footer">
        {!! \Form::submit() !!}
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-22">
        <div class="box box-primary box-solid">
          <div class="box-header ">
            <h3 class="box-title">Bill of Materials for {{ $payload['qty'] }} {{ \SeIT\Services\DB::getTypeNameById($payload['baseTypeID']) }}</h3>
            <div class="box-tools">&nbsp;</div>
          </div>
          <div class="box-body">
            <table class="table">
              <thead>
                  <th>Material</th>
                  <th>Quantity</th>
              </thead>
              <tbody>
              @foreach($payload['materials_required'] as $material => $quantity)
              <tr>
                <td>{{ \SeIT\Services\DB::getTypeNameById($material) }}</td>
                <td>{{ $quantity }}</td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-22">
        <div class="box box-primary box-solid">
          <div class="box-header ">
            <h3 class="box-title">Build Time for {{ $payload['qty'] }} {{ \SeIT\Services\DB::getTypeNameById($payload['baseTypeID']) }}</h3>
            <div class="box-tools">&nbsp;</div>
          </div>
          <div class="box-body">
            @if($payload['time']->y > 0) 
              {!! $payload['time']->y !!} Year(s)
            @endif
            @if($payload['time']->m > 0) 
              {!! $payload['time']->m !!} Month(s)
            @endif
            @if($payload['time']->d > 0) 
              {!! $payload['time']->d !!} Day(s)
            @endif
            @if($payload['time']->h > 0) 
              {!! $payload['time']->h !!} Hour(s)
            @endif
            @if($payload['time']->i > 0) 
              {!! $payload['time']->i !!} Minute(s)
            @endif
            @if($payload['time']->s > 0) 
              {!! $payload['time']->s !!} Second(s)
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
