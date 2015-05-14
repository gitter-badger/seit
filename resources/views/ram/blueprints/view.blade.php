@extends('layouts.masterLayout')

@section('html_title', 'Blueprints')
@section('page_content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header ">
        <h3 class="box-title">Blueprints</h3>
        <div class="box-tools">&nbsp;</div>
      </div>
      <div class="box-body">
        <table class="table condensed" id="extended-dt">
            <thead>
                <tr>
                    <th>Blueprint</th>
                    <th>TE</th>
                    <th>ME</th>
                    <th>Character</th>
                    <th>Quantity</th>
                    <th>Runs</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Blueprint</th>
                    <th>TE</th>
                    <th>ME</th>
                    <th>Character</th>
                    <th>Quantity</th>
                    <th>Runs</th>
                </tr>
            </tfoot>
            <tbody>
              @foreach($payload['blueprints'] as $blueprint)
                <tr>
                    <td>{{ $blueprint->typeName }}</td>
                    <td>{{ $blueprint->timeEfficiency }}</td>
                    <td>{{ $blueprint->materialEfficiency }}</td>
                    <td>{{ $blueprint->characterName }}</td>
                    <td>{{ $blueprint->qty }}</td>
                    <td>{{ $blueprint->runs }}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </div>
</div>
@stop

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $('#extended-dt').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
</script>

@stop
