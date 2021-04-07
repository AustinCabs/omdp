<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Billing Data Settings</h3>
      <div class="box-tools">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
    <div class="mailbox-controls">
        <!-- Check all button -->
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#new-bill"><i class="fa fa-plus"></i> Add new Permit</button>
        </div>
        <!-- /.btn-group -->
        <!-- /.pull-right -->
      </div>
      
      <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
          <tbody>
          @if (count($permitTypes) == 0)
            <tr><td>No setting available. </td> </tr>
          @endif
          @foreach ($permitTypes as $row)
            <tr class="permit-{{ $row->id }}" name="{{ $row->name }}">
              <td class="permit-name"><a data-toggle="modal" data-target="#update-bill" data-id="{{ $row->id }}" class="trigger-bill-modal">{{ $row->name }}</a></td>
              <td class="permit-type" data-id="{{ $row->type }}"> <b>{{ ($row->type == 0) ? 'Mining' : 'Quarry' }}</b></td>
              <td class="permit-attachment"> {{ $row->doc_name }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <!-- /.table -->
      </div>
      <!-- /.mail-box-messages -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer no-padding">
    {{-- 
      <div class="mailbox-controls">
        <!-- Check all button -->
        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
        </button>
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
        </div>
        <!-- /.btn-group -->
        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
        <div class="pull-right">
          1-50/200
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
          </div>
          <!-- /.btn-group -->
        </div>
        <!-- /.pull-right -->
      </div>
    --}}
      
    </div>
  </div>

  @section('customjs')
  <script type="text/javascript">
    $(function(){

      //update modal trigger
      $('.trigger-bill-modal').on('click', function(e){
        var id = $(e.target).data('id');
        var jqxhr = $.ajax({
          method: "get",
          url: "{{ url('/api/permit_type_bill/') }}/"+id,
        })
        .done(function(data){
          var table = $('#billing-types');
          var type = $(e.target).parent().siblings('.permit-type').data('id');
          $('#billing-types tbody').empty();
          var count = data.length;
          var name = $(e.target).text()
          $('select.permit-type').val(type);
          for (var i = 0; i != count; i++) {
            table.append('<tr><td>'+data[i].name+'</td><td class="fee-container"><input class="form-control bill-fee" type="number" value="'+data[i].fee+'"></td><td><a data-id="'+data[i].id+'" class="btn btn-primary save-bill-fee"><i class="fa fa-save"></i></a><a class="btn btn-warning delete-bill" data-id="'+data[i].id+'"><i class="fa fa-close"></i></a></td></tr>')
          }
          $('.permit-id').val(id)
          $('.bill-name').text(name)
        })
      });
      //update billing fee
      $(document).on('click', '.save-bill-fee', function(e){
        e.preventDefault();
        var id = $(this).data('id')
        var parent = $(this).parent();
        var fee = parent.closest('td').siblings().find('input.bill-fee').val();
        var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/save-billing-fee/') }}/"+id,
          data : { 'fee' : fee, 'api_token' : '{{ Auth::user()->api_token }}' },
        })
        .done(function(data){
          if(data.type == 'success'){
            $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
          }else{
            $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
          }
          
        })
      });


    })
  </script>
  @endsection
 
 @include('adminlte::settings.data-settings.modals.update')
 @include('adminlte::settings.data-settings.modals.new')