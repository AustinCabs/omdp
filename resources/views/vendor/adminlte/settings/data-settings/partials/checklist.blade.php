<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Checklist Data Settings</h3>
      <div class="box-tools">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
    <div class="mailbox-controls">
      </div>
      
      <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
          <tbody>
          @if (count($permitTypes) == 0)
            <tr><td>No setting available. </td> </tr>
          @endif
          @foreach ($permitTypes as $row)
            <tr class="permit-{{ $row->id }}" name="{{ $row->name }}">
              <td class="permit-name"><a data-toggle="modal" data-target="#checklist" data-id="{{ $row->id }}" class="trigger-permit-modal">{{ $row->name }}</a></td>
              <td class="permit-type" data-id="{{ $row->type }}"> <b>{{ ($row->type == 0) ? 'Mining' : 'Quarry' }}</b></td>
              <td class="permit-checks"><span class="badge bg-blue"> {{ count($row->checks) }} Checklists</span></td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <!-- /.table -->
      </div>
      <!-- /.mail-box-messages -->
    </div>
    <!-- /.box-body -->
   
  </div>
@include('adminlte::settings.data-settings.modals.checklist')
<script type="text/javascript">
  $(function(){
    $('.trigger-permit-modal').on('click', function(e){
      e.preventDefault()
      var id = $(this).data('id')
      var jqxhr = $.ajax({
          method: "get",
          url: "{{ url('/api/getChecks/') }}/"+id,
        })
        .done(function(data){
          var table = $('#requirements-tbl')
          var count = data.checks.length;
          $('.permit-id').val(id)
          for (var i = 0; i != count; i++) {
            table.append('<tr id="checklist-'+data.checks[i].id+'"><td>'+data.checks[i].name+'</td><td><a class="delete-req" data-id="'+data.checks[i].id+'"><i class="fa fa-close"></i></a></td></tr>')
          }
        })
    })
  })
</script>

