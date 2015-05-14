<table class="table table-condensed table-bordered table-striped" id="datatable">
  <thead>
    <tr>
        <th width="25%"> Item Name </th>
        <th width="25%"> Base Price </th>
        <th width="25%"> Average Price </th>
        <th width="25%"> Adjusted Price </th>
    </tr>
  </thead>
  <tbody>
    @foreach($payload as $e)
      <tr>
        <td>{{ $e->typeName }}</td>
        <td>{{ round($e->basePrice, 2) }}</td>
        <td>{{ round($e->averagePrice, 2) }}</td>
        <td>{{ round($e->adjustedPrice, 2) }}</td>
      </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
        <th width="25%"> Item Name </th>
        <th width="25%"> Base Price </th>
        <th width="25%"> Average Price </th>
        <th width="25%"> Adjusted Price </th>
    </tr>
  </tfoot>
</table>
