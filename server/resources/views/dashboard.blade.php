@extends('layout.index')

@section('content')

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Dashboard</h3>
            </div>

            <div class="flex row">
                <div class="col-3 gap20 ">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Total Users</div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h1>12</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-3 gap20">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Total Product</div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h1>23</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-3 gap20">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Total Comments</div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h1>545</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-3 gap-20">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Total Reaction</div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h1>122</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





