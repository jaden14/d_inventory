@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">For Release
                    <span style="float: right;">
                       <button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    </span>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Date</th>
                                <th class="sorting" style="width: 25%; cursor: pointer;">Branch </th>
                                <th class="sorting" style="width: 25%; cursor: pointer;">item Name</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Qty</th>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Unit</th>
                                <th class="text-center sorting" style="width: 5%; cursor: pointer;">Action</th>
                                </tr>
                            </thead>
                            @forelse($release as $releases)
                            <tbody>
                                <tr>
                                    <td>{{ date(" F j, Y ", strtotime($releases->date)) }}</td>
                                    <td>{{ $releases->branch->name }}</td>
                                    <td>{{ $releases->stock->name }}</td>
                                    <td>{{ $releases->qty }}</td>
                                    <td>{{ $releases->unit->name }}</td>
                                    <td>
                                        <div role="group" class="btn-group">
                                            <button data-id="{{ $releases->id }}"  class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button> 
                                        </div>
                                    </td>   
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="7">No records found.</td>
                            @endforelse
                        </table>
                        {{ $release->appends(request()->except('page'))->links() }}
                          <div class="form-group row col-md-5" style="float: right; padding-right:0px; margin-right: 0px;">
                            <div class="col-md-3">
                                <label style="font-size: 15px; margin-top: 8px;"><b>Total Qty:</b></label>
                            </div>
                            <div class="col-md-3">
                            <input type="text" class="form-control" readonly value="{{ $released }}">
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger print"><i class="fa fa-print"></i> Print</button>
                                @if($released != null)
                                <button class="btn btn-primary deliver"><i class="fa fa-motorcycle"></i> Deliver</button>
                                @else
                                <button class="btn btn-primary save_item" disabled style="cursor: not-allowed;"><i class="fa fa-motorcycle"></i> Deliver</button>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label><i style="color: red;"> Note! Once you click Deliver, your items can't be undone. </i></label>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!--create-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">For Release Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    
                    <div class="form-group row">   
                        <div class="col-md-6">                 
                            <label for="date">Date<i style="color: red">*</i></label>
                            <input type="date" value="{{ $date->format('Y-m-d') }}" class="form-control date" autofocus>
                        </div>
                    </div>
                        <div class="form-group row">
                            <div class="col-md-6">                        
                                <label for="name">Branch Name<i style="color: red">*</i></label>
                                <select id="stock" class="form-control branch_id" >
                                    <option selected disabled>choose</option>
                                    @foreach($branch as $branches)
                                    <option value="{{ $branches->id }}">{{ $branches->name }}</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="col-md-6">                        
                                <label for="name">Item Name<i style="color: red">*</i></label>
                                <select id="stock" class="form-control stock_id" >
                                    <option selected disabled>choose</option>
                                    @foreach($stock as $stocks)
                                    <option value="{{ $stocks->id }}">{{ $stocks->name }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>
                  <div class="form-group row"> 
                        <div class="col-md-6">                 
                            <label for="qty">Qty Available : <i style="color: red"> <input type="text" readonly class="col-md-1 qtt" style="margin: 0; border: 0; padding: 0; " autofocus></i></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="qty" class="form-control qty" autofocus>
                        </div>   
                        <div class="col-md-6">                   
                            <label for="unit_id">Unit<i style="color: red">*</i></label>
                            <select class="form-control unit_id" autofocus>
                                @foreach($unit as $units)
                                <option value="{{ $units->id }}">{{ $units->name }}</option>
                                @endforeach
                            </select>
                        </div>
                  </div>
                  <div class="form-group row">               
                            <input type="hidden" class="form-control user_id" value="{{ auth::user()->id }}" autofocus>
                  </div>

            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save" id="save"><i class="fa fa-save"></i> save</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/release.print" method="GET" role="search">
            <div class="modal-body">
                 <div class="form-group">
                    <label for="from">Date<i style="color: red">*</i></label>
                    <input type="date" class="form-control date" name="date"  id="date"  autofocus required>
                </div>
                    
                <button type="submit" class="btn btn-danger printer"><i class="fa fa-print"></i> print</button>
            </div>
            </form>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deliverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div class="form-group">
                    <label for="from">Date<i style="color: red">*</i></label>
                    <input type="date" class="form-control dated" name="date"  id="date"  autofocus required>
                    <input type="hidden" class="form-control user" value="{{ auth::user()->id }}" >
                </div>
                    
                <button type="submit" class="btn btn-primary printer save_item"><i class="fa fa-motorcycle"></i> Deliver</button>
            </div>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function () {
        $('.add').click(function(){
            $('#myModal').modal('show')
        })

        $('.print').click(function(){
            $('#printModal').modal('show')
        })
        $('.deliver').click(function(){
            $('#deliverModal').modal('show')
        })
    })



    $('.save').click(function() {
            $.post('{{ route("release.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        date: $('.date').val(),
                        branch_id: $('.branch_id').val(),
                        stock_id: $('.stock_id').val(),
                        quantity: $('.qtt').val(),
                        qty: $('.qty').val(),
                        unit_id: $('.unit_id').val(),
                        user_id: $('.user_id').val(),
                    })
                    .done(function (response) {
                        $.notify("Done", "success");
                        $('#myModal').modal('hide')
                        setTimeout( function()
                        {
                            location.reload();
                        }, 500);
                }).fail(function (response) {
                    var errors = _.map(response.responseJSON.errors)
                        $.notify(errors[0], "error");
                });
        })

   $(document).on('click', '.btn_delete', function() {
            var id = $(this).data('id')

            Swal.fire({
                title: 'Are you sure?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    $('input[name=id').val(id)
                        $.post('{{ route("releasedelete") }}', {
                        "_token": "{{ csrf_token() }}",
                    id: id
                    })
                    .done(function (response) {})
                    setTimeout( function()
                        {
                            location.reload();
                        }, 2000)
                    Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success',
                    
                    )
                }
            })

        })

   $('.save_item').click(function() {
            $.post('{{ route("releaseitem") }}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('.user').val(),
                        date: $('.dated').val(),
                    })
                    .done(function (response) {
                        $.notify("Done", "success");
                        $('#myModal').modal('hide')
                        setTimeout( function()
                        {
                            location.reload();
                        }, 500);
                }).fail(function (response) {
                    var errors = _.map(response.responseJSON.errors)
                        $.notify(errors[0], "error");
                });
        });

   $(document).ready(function(){
    $(document).on('change','.stock_id',function(){

      var stock_id=$(this).val();
       console.log(stock_id);
      var div=$(this).parent();

      var op=" ";

      $.ajax({
        type:'get',
        url:'{!!URL::to('stocking')!!}',
        data:{'id':stock_id},
        success:function(data){

          console.log(data.qty);
             $('.qtt').val(data.qty)

        if(data.qty == 0)
        {
            document.getElementById("save").disabled=true;
            document.getElementById("qty").disabled=true;
        } else {
            document.getElementById("save").disabled=false;
            document.getElementById("qty").disabled=false;
        }

        },
        error:function(){

        }
      });
    });
});

</script>
@endsection