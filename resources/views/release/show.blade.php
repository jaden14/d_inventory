@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Released History
                    <span style="float: right;">
                       <button  class="btn btn-danger btn-sm print"><i class="fa fa-print"></i> print</button> 
                    </span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                      <form action="{{ route('historysearchs') }}" method="GET" role="search">
                        <div class="row">
                            <div class="col-md-3">
                                <input name="date" type="date" class="form-control" >
                            </div>
                             <div class="col-md-3">
                                <select name="branch" class="form-control">
                                    <option disabled selected="true">Branch</option>
                                  @foreach($branch as $branch)  
                                    <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input name="item" type="text" class="form-control" placeholder="Search Item">
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
                                <th class="sorting" style="width: 30%; cursor: pointer;">Branch </th>
                                <th class="sorting" style="width: 40%; cursor: pointer;">item Name</th>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Qty</th>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Unit</th>
                            </thead>
                            @forelse($release as $releases)
                            <tbody>
                                <tr>
                                    <td>{{ $releases->branch->name }}</td>
                                    <td>{{ $releases->stock->name }}</td>
                                    <td>{{ $releases->qty }}</td>
                                    <td>{{ $releases->unit->name }}</td>  
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="4">No records found.</td>
                            @endforelse
                        </table>
                        {{ $release->appends(request()->except('page'))->links() }}
                    </div>
                   
                </div>
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
            <form action="/released.print" method="GET" role="search">
                <div class="modal-body">
                 <div class="form-group">
                    <label for="from">Date<i style="color: red">*</i></label>
                    <input type="date" class="form-control date" name="date"  id="date"  autofocus required>
                </div>
                </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-danger printer"><i class="fa fa-print"></i> print</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function () {
        $('.print').click(function(){
            $('#printModal').modal('show')
        })
    })
</script>
@endsection