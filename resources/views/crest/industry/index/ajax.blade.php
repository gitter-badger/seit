<table class="table table-condensed table-bordered table-striped" id="datatable">
  <thead>
    <th width="22%"> Solarsystem </th>
    <th width="13%"> Security </th>
    <th width="13%"> Manufacturing </th>
    <th width="13%"> ME Research </th>
    <th width="13%"> TE Research </th>
    <th width="13%"> Copy </th>
    <th width="13%"> Invention </th>
    </tr>
  </thead>
  <tbody>
    @foreach($payload as $e)
      <tr>
        <td>{{ $e->solarSystemName }}</td>
        <td>{{ round($e->security, 2) }}</td>
        <td>{{ round($e->manufacturingIndex*100, 3) }}</td>
        <td>{{ round($e->meResearchIndex*100, 3) }}</td>
        <td>{{ round($e->teResearchIndex*100, 3) }}</td>
        <td>{{ round($e->copyIndex*100, 3) }}</td>
        <td>{{ round($e->inventionIndex*100, 3) }}</td>
      </tr>
    @endforeach
  </tbody>
  <tfoot>
    <th> Solarsystem </th>
    <th> Security </th>
    <th> Manufacturing </th>
    <th> ME Research </th>
    <th> TE Research </th>
    <th> Copy </th>
    <th> Invention </th>
    </tr>
  </tfoot>
</table>
