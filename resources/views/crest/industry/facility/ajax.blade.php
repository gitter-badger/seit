<table class="table table-condensed table-bordered table-striped" id="datatable">
  <thead>
    <th width="20%"> Solarsystem </th>
    <th width="35%"> Station Name </th>
    <th width="5%"> Tax </th>
    <th width="20%"> Station Type </th>
    <th width="20%"> Owner </th>
    </tr>
  </thead>
  <tbody>
    @foreach($payload as $e)
      <tr>
        <td>{{ $e->solarSystemName }}</td>
        <td>{{ $e->stationName }}</td>
        @if($e->tax == null)
        <td> N/A </td>
        @else
        <td>{{ round($e->tax, 2)*100 }} %</td>
        @endif
        <td>{{ $e->typeName }}</td>
        <td>{{ \SeIT\Services\Helper::resolveIdToName($e->ownerID) }}</td>
      </tr>
    @endforeach
  </tbody>
  <tfoot>
    <th> Solarsystem </th>
    <th> Station Name </th>
    <th> Tax </th>
    <th> Station Type </th>
    <th> Owner </th>
    </tr>
  </tfoot>
</table>
