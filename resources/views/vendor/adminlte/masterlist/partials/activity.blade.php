
<div class="tab-pane" id="activity">
  <div class="box"> 
    <div class="box-header">
      <h3 class="box-title">Activity Logs</h3>
    </div>
    <div class="box-body">
      <table class="table table-hover">
        <tbody>
          @if (count($history) == 0)
            <tr>No activity recorded.</tr>
          @else
            @foreach($history as $row)
            <tr>
              <td>{{ $row->action }}</td>
              <td><label class="pull-right"> {{ Carbon\Carbon::createFromTimeStamp(strtotime($row->created_at))  }} </label></td>
            </tr>
          @endforeach
          @endif
          
        </tbody>
      </table>
    </div>
  </div> 
</div>