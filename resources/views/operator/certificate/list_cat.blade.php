@extends('operator.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h3>{{ $page_title }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card-body">
                    <ul class="nav nav-pills navtab-bg nav-justified">
                        @if ($levels->count() > 0)
                            @foreach ($levels as $level)
                                <li class="nav-item">
                                    <a href="#{{ $level->short_name_english }}" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link {{ request()->get('tab') == $level->short_name_english ? 'active' : '' }}">
                                        {{ $level->short_name_english }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <hr>
                    <div class="tab-content">
                        <div class="tab-pane {{ request()->get('tab') == 'Specialization' ? 'active' : '' }}" id="Specialization">
                            <div class="row">
                                @if (isset($program_wise_counts['1']) && count($program_wise_counts['1']) > 0)
                                    @foreach ($program_wise_counts['1'] as $master)
                                        @if($master['count'])
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="{{route('operator-program-wise-certificate-list',['id'=> $master['program_id'], 'isPrinted' => $is_printed ]) }}" class="text-center">
                                                            <h2 class="inbox-item-number">{{ $master['count'] }}</h2>
                                                            <h4 class="inbox-item-author mt-0 mb-1">{{ $master['program_name'] }}</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p>No programs found for the master level.</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane {{ request()->get('tab') == 'First' ? 'active' : '' }}" id="First">
                            <div class="row">
                                @if (isset($program_wise_counts['2']) && count($program_wise_counts['2']) > 0)
                                    @foreach ($program_wise_counts['2'] as $bachelor)
                                        @if($bachelor['count'])
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="{{route('operator-program-wise-certificate-list',['id'=> $bachelor['program_id'], 'isPrinted' => $is_printed ]) }}" class="text-center">
                                                            <h2 class="inbox-item-number">{{ $bachelor['count'] }}</h2>
                                                            <h4 class="inbox-item-author mt-0 mb-1">{{ $bachelor['program_name'] }}</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p>No programs found for the bachelor level.</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane {{ request()->get('tab') == 'Second' ? 'active' : '' }}" id="Second">
                            <div class="row">
                                @if (isset($program_wise_counts['3']) && count($program_wise_counts['3']) > 0)
                                    @foreach ($program_wise_counts['3'] as $pcl_plus2)
                                        @if($pcl_plus2['count'])
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="{{route('operator-program-wise-certificate-list',['id'=> $pcl_plus2['program_id'], 'isPrinted' => $is_printed ]) }}" class="text-center">
                                                            <h2 class=" inbox-item-number">{{ $pcl_plus2['count'] }}</h2>
                                                            <h4 class="inbox-item-author mt-0 mb-1">{{ $pcl_plus2['program_name'] }}</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p>No programs found for the PCL / +2 level.</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane {{ request()->get('tab') == 'Third' ? 'active' : '' }}" id="Third">
                            <div class="row">
                                @if (isset($program_wise_counts['4']) && count($program_wise_counts['4']) > 0)
                                    @foreach ($program_wise_counts['4'] as $tslc)
                                        @if($tslc['count'])
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="{{route('operator-program-wise-certificate-list',['id'=> $tslc['program_id'], 'isPrinted' => $is_printed ]) }}" class="text-center">
                                                            <h2 class="inbox-item-number">{{ $tslc['count'] }}</h2>
                                                            <h4 class="inbox-item-author mt-0 mb-1">{{ $tslc['program_name'] }}</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p>No programs found for the TSLC level.</p>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="tab-pane {{ request()->get('tab') == 'SLC' ? 'active' : '' }}" id="SLC">
                            <div class="row">
                                @if (isset($program_wise_counts['5']) && count($program_wise_counts['5']) > 0)
                                    @foreach ($program_wise_counts['5'] as $slc)
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a href="#" class="text-center">
                                                        <h2 class="text-warning inbox-item-number">{{ $slc['count'] }}</h2>
                                                        <h4 class="inbox-item-author mt-0 mb-1">{{ $slc['program_name'] }}</h4>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No programs found for the SLC level.</p>
                                @endif
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .inbox-item-number{
            color: rgb(235 208 0);
        }
        .inbox-item-author{
            background: rgb(25, 122, 159,75%);
            border-radius: 4px;
            padding: 4px;
            color: #fff;
            font-size: 20px
        }
        .tab-content .card-body:hover{
            background: rgba(3, 94, 112, 0.297);
            transition: all 0.3s ease;
        }
        .tab-content .card-body:hover .inbox-item-author{
            background: rgba(255, 255, 255, 0.342);
            color: #006b9d;
            transition: all 0.3s ease;
        }
        .tab-content .card-body:hover .inbox-item-number{
            color: #ffffff;
            transition: all 0.3s ease;
            /* background:  */
        }
        </style>
@endsection
@section('footer-scripts')
    @include('operator.certificate.js.list')
@endsection
