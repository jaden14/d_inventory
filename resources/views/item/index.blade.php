@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Item to stock
                    <span style="float: right;">
                       <button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    </span>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Date</th>
                                <th class="sorting" style="width: 25%; cursor: pointer;">Item </th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Qty</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Unit</th>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Unit Price</th>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Amount</th>
                                <th class="text-center sorting" style="width: 10%; cursor: pointer;">Action</th>
                                </tr>
                            </thead>
                            @forelse($item as $items)
                            <tbody>
                                <tr>
                                    <td>{{ date(" F j, Y ", strtotime($items->date)) }}</td>
                                    <td>{{ $items->stock->name }}</td>
                                    <td>{{ $items->qty }}</td>
                                    <td>{{ $items->unit->name }}</td>
                                    <td>{{ $items->price }}</td>
                                    <td>{{ number_format($items->amount, 2) }}</td>
                                    <td>
                                        <div role="group" class="btn-group">
                                            <button data-id="{{ $items->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button> 

                                            <button data-id="{{ $items->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>
                                        </div>
                                    </td>   
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="7">No records found.</td>
                            @endforelse
                        </table>
                        {{ $item->appends(request()->except('page'))->links() }}
                        <div class="form-group row col-md-5" style="float: right; padding-right:0px; margin-right: 0px;">
                            <div class="col-md-4">
                                <label style="font-size: 15px; margin-top: 8px;"><b>Total Amount:</b></label>
                            </div>
                            <div class="col-md-5">
                            <input type="text" class="form-control" readonly value="{{ number_format($total, 2) }}">
                            <input type="hidden" class="form-control user" value="{{ auth::user()->id }}" >
                            </div>
                            <div class="col-md-3">
                                @if($total != null)
                                <button class="btn btn-primary save_item"><i class="fa fa-save"></i> save</button>
                                @else
                                <button class="btn btn-primary save_item" disabled style="cursor: not-allowed;"><i class="fa fa-save"></i> save</button>
                                @endif
                            </div>
                             <div class="col-md-12">
                                <label><i style="color: red;"> Note! Once you click Save, your items can't be undone. </i></label>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
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
                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                          <input type="hidden" name="item_inside" value="0"/>
                          <input type="checkbox" name="item_inside" value="1" class="form-check-input" id="item_inside" onclick="myFunction()"><i style="color: red;">Please Check if Item not found.</i></label>
                      </div>
                    <div id="add" style="display: none;">
                        <div class="form-group">                        
                            <label for="name">Item Name<i style="color: red">*</i></label>
                            <input type="text" id="item" class="form-control item_name" autofocus> 
                        </div>
                    </div>
                    <div class="form-group" id="sub">
                        <div class="form-group">                        
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
                            <label for="unit_id">Unit<i style="color: red">*</i></label>
                            <select class="form-control unit_id" autofocus>
                                @foreach($unit as $units)
                                <option value="{{ $units->id }}">{{ $units->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">                 
                            <label for="qty">Qty<i style="color: red">*</i></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control qty" autofocus>
                        </div> 
                  </div>
                  <div class="form-group row">
                        <div class="col-md-6">                 
                            <label for="price">Unit Price<i style="color: red">*</i></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control price" autofocus>
                        </div>
                        <div class="col-md-6">                 
                            <label for="amount">total Amount<i style="color: red">*</i></label>
                            <input type="text" readonly class="form-control amount" autofocus>
                        </div>
                        <div class="col-md-6">                 
                            
                            <input type="hidden" class="form-control user_id" value="{{ auth::user()->id }}" autofocus>
                        </div>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group row">   
                        <div class="col-md-6">                 
                            <label for="date">Date<i style="color: red">*</i></label>
                            <input type="date"  class="form-control dates" autofocus>
                        </div>
                    </div>
                    
                    <div class="form-group" id="sub">
                        <div class="form-group">                        
                            <label for="name">Item Name<i style="color: red">*</i></label>
                            <select id="stock" class="form-control stock_ids" >
                                <option selected disabled>choose</option>
                                @foreach($stock as $stocks)
                                <option value="{{ $stocks->id }}">{{ $stocks->name }}</option>
                                @endforeach
                            </select>    
                        </div>
                    </div>
                  <div class="form-group row">   
                        <div class="col-md-6">                   
                            <label for="unit_id">Unit<i style="color: red">*</i></label>
                            <select class="form-control unit_ids" autofocus>
                                @foreach($unit as $units)
                                <option value="{{ $units->id }}">{{ $units->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">                 
                            <label for="qty">Qty<i style="color: red">*</i></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control qtys" autofocus>
                        </div> 
                  </div>
                  <div class="form-group row">
                        <div class="col-md-6">                 
                            <label for="price">Unit Price<i style="color: red">*</i></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control prices" autofocus>
                        </div>
                        <div class="col-md-6">                 
                            <label for="amount">total Amount<i style="color: red">*</i></label>
                            <input type="text" readonly class="form-control amounts" autofocus>
                        </div>
                        <div class="col-md-6">                 

                            <input type="hidden" name="id" class="form-control id" autofocus>
                        </div>
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
    function myFunction() {
    var checkBox = document.getElementById("item_inside");
    var div = document.getElementById("add");
    if (checkBox.checked == false) {
      document.getElementById("stock").disabled=false;
      document.getElementById("item").disabled=true;
      document.getElementById('sub').style.display = 'block';
      div.style.display = "none";
    } else {
      document.getElementById("stock").disabled=true;
      document.getElementById("item").disabled=false;
      document.getElementById('sub').style.display = 'none';
      div.style.display = "block";
    }
  }
    $(function () {
        $('.add').click(function(){
            $('#myModal').modal('show')
        })
    })

    $('.save').click(function() {
            $.post('{{ route("item.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        date: $('.date').val(),
                        stock_id: $('.stock_id').val(),
                        item_name: $('.item_name').val(),
                        qty: $('.qty').val(),
                        price: $('.price').val(),
                        amount: $('.amount').val(),
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

   $(document).on('click', '.btn_edit', function() {
            var id = $(this).data('id')
            console.log(id);
            $('#editModal').modal('show');

            $.post('/item/item_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.id').val(id)
                $('.dates').val(response.date)
                $('.stock_ids').val(response.stock_id)
                $('.unit_ids').val(response.unit_id)
                $('.qtys').val(response.qty)
                $('.prices').val(response.price)
                $('.amounts').val(response.amount)
            })

          })

   $('.save_edit').click(function(){

            $.post('{{ route("itemupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('input[name=id').val(),
                        date: $('.dates').val(),
                        stock_id: $('.stock_ids').val(),
                        qty: $('.qtys').val(),
                        price: $('.prices').val(),
                        amount: $('.amounts').val(),
                        unit_id: $('.unit_ids').val(),
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
                        $.post('{{ route("itemdelete") }}', {
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
            $.post('{{ route("itemstock") }}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('.user').val(),
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

   $(document).ready(function() {

    $('.qty').keyup(function(event) {
      var qty = Number($(this).val());

      $('.price').keyup(function(event) {
      var price = Number($(this).val());

      $('.amount').val((price * qty).toFixed(2));

    });

    });

  });

    $(document).ready(function() {

    $('.qtys').keyup(function(event) {
      var qty = Number($(this).val());

      $('.prices').keyup(function(event) {
      var price = Number($(this).val());

      $('.amounts').val((price * qty).toFixed(2));

    });

    });

  });

</script>
@endsection