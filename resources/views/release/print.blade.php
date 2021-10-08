@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    {{ date(" F \\ j, Y", strtotime($date)) }}
                    <span style="float: right;">
                       Status: <b>{{ $status }}</b>
                    </span>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 30%; cursor: pointer;">Branch </th>
                                <th class="sorting text-center" colspan="3" style="width: 70%; cursor: pointer;">STOCK/INGREDIENTS </th>
                            </thead>
                            @forelse($release as $releases => $releam)
                            <tbody>
                                <tr>
                                    <td colspan="3"><b>{{ $releam[0]->branch->name }}</b></td>
                                </tr>
                                @foreach($releam as $releams)
                                <tr>
                                    <td></td>
                                    <td>{{ $releams->stock->name }}</td>
                                    <td>{{ $releams->qty }} {{ $releams->unit->name }}</td>  
                                </tr>
                                @endforeach
                            </tbody>
                           	@empty
                                <td colspan="4">No records found.</td>
                            @endforelse
                        </table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection