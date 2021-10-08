@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Purchased History
                </div>
                <div class="card-body">
                    <div class="mb-3">
                      <form action="{{ route('historysearch') }}" method="GET" role="search">
                        <div class="row">
                            <div class="col-md-5">
                                <input name="date" type="date" class="form-control" >
                            </div>
                            <div class="col-md-5">
                                <input name="item" type="text" class="form-control" placeholder="Search Item">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="form-control btn btn-sm btn-primary" style="font-size: 11px;">Search</button> 
                            </div>
                        </div>
                      </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 35%; cursor: pointer;">Item </th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Qty</th>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Unit</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Unit Price</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Amount</th>
                            </thead>
                            @forelse($item as $items)
                            <tbody>
                                <tr>
                                    <td>{{ $items->stock->name }}</td>
                                    <td>{{ $items->qty }}</td>
                                    <td>{{ $items->unit->name }}</td>
                                    <td>{{ number_format($items->price, 2) }}</td>
                                    <td>{{ number_format($items->amount, 2) }}</td>   
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="5">No records found.</td>
                            @endforelse
                        </table>
                        {{ $item->appends(request()->except('page'))->links() }} 
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
