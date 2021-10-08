@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="main-panel col-md-12">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="card" style="background-color:#d14d4d;">
                  <div class="card-body">
                    
                    <h4 class="font-weight-normal mb-3" style="color: white;">Total Item qty in Stock 
                    </h4>
                    <h2 class="mb-5" style="color: white;">{{ number_format($item) }}</h2>
                    <h6 class="card-text" style="color: white;">Pending Items: {{$items}}</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card" style="background-color:#651a1a;">
                  <div class="card-body">
                    <h4 class="font-weight-normal mb-3" style="color: white;"> Remaining Item qty Available 
                    </h4>
                    <h2 class="mb-5" style="color: white;">{{ number_format($stock) }}</h2>
                    <h6 class="card-text" style="color: white;">Items Out of Stock: {{ $stocks }}</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 ">
                <div class="card" style="background-color:#00d600;">
                  <div class="card-body">
                    
                    <h4 class="font-weight-normal mb-3" style="color: white;">Total Item qty Released  <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5" style="color: white;">{{ number_format($release) }}</h2>
                    <h6 class="card-text" style="color: white;">Item for Release: {{ $released }}</h6>
                  </div>
                </div>
              </div>
            </div> 
          </div>
    </div>
</div>
@endsection
