@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title" style="font-size: 25px;">Dashboard</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="d-flex card-header justify-content-between align-items-center">
                <div class="col-12">
                    <h4 class="header-title">Dashboard Chart</h4>
                </div>
            </div>

            <div class="card-body pt-0">
                <h4 class="header-title"></h4>
                <div dir="ltr">
                    <div class="row">
                        <div class="col-sm-6">
                            <figure class="highcharts-pie">
                                <div id="pie-chart"></div>
                            </figure>
                        </div>
                        <div class="col-sm-6">
                            <figure class="highcharts-bar">
                                <div id="bar-chart" style="display: none;"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
@section('js-page')
@vite('resources/css/pie-chart.css')
@vite('resources/js/chart/pie-chart.js')
@vite('resources/css/bar-chart.css')
@vite('resources/js/chart/bar-chart.js')
@endsection
@endsection