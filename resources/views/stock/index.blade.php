@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Stocks
                    <span style="float: right;">
                       <button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    </span>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 30%; cursor: pointer;">Item </th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Qty</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Status</th>
                                <th class="sorting" style="width: 30%; cursor: pointer;">Last Updated</th>
                                <th class="text-center sorting" style="width: 10%; cursor: pointer;">Action</th>
                                </tr>
                            </thead>
                            @forelse($stock as $stocks)
                            <tbody>
                                <tr>
                                    <td>{{ $stocks->name }}</td>
                                    <td>{{ $stocks->qty }}</td>
                                    <td>
                                    @if($stocks->status =='Available')
                            			<label class="badge badge-success">Available</label>
                            		@else
                            			<label class="badge badge-danger">Out of Stocks</label>
                            		@endif
                            		</td>
                                    <td>{{ date(" F j, Y g:i a", strtotime($stocks->updated_at)) }}</td>
                                    <td>
                                        <div role="group" class="btn-group">
                                            <button data-id="{{ $stocks->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button> 
                                        </div>
                                    </td>   
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="7">No records found.</td>
                            @endforelse
                        </table>
                        {{ $stock->appends(request()->except('page'))->links() }}
                          
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!--add-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    
                    <div class="form-group" id="sub">
                        <div class="form-group">                        
                            <label for="name">Item Name<i style="color: red">*</i></label>
                            <input type="text" id="name" class="form-control stock_name" autofocus>
                        </div>
                    </div>
                    <div class="form-group">            
                            <label for="qty">Qty<i style="color: red">*</i></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control qty" autofocus>
                    </div>           
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save"><i class="fa fa-save"></i> save</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>

<!--edit-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    
                    <div class="form-group" id="sub">
                        <div class="form-group">                        
                            <label for="name">Item Name<i style="color: red">*</i></label>
                            <input type="text" id="name" class="form-control name" autofocus>
                        </div>
                    </div>
                    <input type="hidden" name="id" class="form-control id" autofocus>
                    <div class="form-group">            
                            <label for="qty">Qty<i style="color: red">*</i></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control qtys" autofocus>
                    </div>
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save_edit"><i class="fa fa-save"></i> save</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function () {
        $('.add').click(function(){
            $('#addModal').modal('show')
        })
    })

    $('.save').click(function() {
            $.post('{{ route("stock.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        name: $('.stock_name').val(),
                        qty: $('.qty').val(),
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
   $(document).on('click', '.btn_edit', function() {
            var id = $(this).data('id')
            console.log(id);
            $('#editModal').modal('show');

            $.post('/stock/stock_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.id').val(id)
                $('.name').val(response.name)
                $('.qtys').val(response.qty)
            })

          })

   $('.save_edit').click(function(){

            $.post('{{ route("stockupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('input[name=id').val(),
                        name: $('.name').val(),
                        qty: $('.qtys').val(),
  
                    })
                    .done(function (response) {
                        $('#editModal').modal('hide');
                        $.notify("Update Success", "success");
                        setTimeout( function()
                        {
                            location.reload();
                        }, 500);
                        
                    }).fail(function (response) {
                    var errors = _.map(response.responseJSON.errors)
                        $.notify(errors[0], "error");
                });
        })

</script>
@endsection