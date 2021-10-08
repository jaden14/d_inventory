@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Branch
                    <span style="float: right;">
                       <button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    </span>
                </div>
                <div class="card-body">
                   
                       <div class="mb-3">
                      <form action="/branch_search" method="GET" role="search">
                        <div class="row">
                            <div class="col-md-10">
                                <input name="branch" type="text" class="form-control" placeholder="search">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="form-control btn btn-sm btn-primary" style="font-size: 11px;">Search</button> 
                            </div>
                        </div>
                      </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 70%; cursor: pointer;">Branch name</th>
                                <th class="text-center sorting" style="width: 30%; cursor: pointer;">Action</th>
                                </tr>
                            </thead>
                            @forelse($branch as $branchs)
                            <tbody>
                                <tr>
                                    <td>{{ $branchs->name }}</td>
                                    <td class="text-center">
                                        <div role="group" class="btn-group">
                                            <button data-id="{{ $branchs->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>
                              
                                            <button data-id="{{ $branchs->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>
                                        </div>
                                    </td>   
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="2">No records found.</td>
                            @endforelse
                        </table>
                        {{ $branch->appends(request()->except('page'))->links() }}   
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!--create-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                        <label for="name">Branch Name<i style="color: red">*</i></label>
                        <input type="text"placeholder="Branch Name" class="form-control name" autofocus>
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
                <h5 class="modal-title" id="exampleModalLabel">Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                        <label for="producers_id">Name<i style="color: red">*</i></label>
                        <input type="text" class="form-control names" autofocus>
                  </div>
                  <div class="form-group">
                        
                        <input type="hidden" name="id" readonly class="form-control id" autofocus style="border:none;">
                  </div>
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save_edit"><i class="fa fa-edit save_edit"></i> Update</button>
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
            $('#myModal').modal('show')
        })
    })

    $('.save').click(function() {
            $.post('{{ route("branch.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        name: $('.name').val(),
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

            $.post('/branch/branch_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.id').val(id)
                $('.names').val(response.name)
            })

          })

   $('.save_edit').click(function(){

            $.post('{{ route("branchupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('input[name=id').val(),
                        name: $('.names').val(),
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
                        $.post('{{ route("branchdelete") }}', {
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

</script>
@endsection