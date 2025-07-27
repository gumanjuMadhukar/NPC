@extends('student.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $page_title }}</h3>
                    </div>
                </div>
            </div>

            @if ($result['exams']->count() > 0)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Licenced Exam</h4>
                            <hr />
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th width="200">Exam Form Open Date</th>
                                            <th width="200">Exam Form End Date</th>
                                            <th>Exam Name</th>
                                            <th>Description</th>
                                            <th width="100">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result['exams'] as $exam)
                                            <tr>
                                                <td>{{ $exam->opening_date }}</td>
                                                <td>{{ $exam->closing_date }}</td>
                                                <td>{{ $exam->name }}</td>
                                                <td>{{ $exam->description }}</td>
                                                <td><a href="{{ route('student-exam-apply', ['id=' . $exam->id]) }}"><span
                                                            class="btn btn-primary">Apply</span></a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">TSLC Licenced Voucher</h4>
                        <hr />
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>TSLC</td>
                                        <td>यो TSLC तहको नाम दर्ताको लागि मात्र हो | यदि यहाँबाट नाम दर्ता प्रमाणपत्र
                                            परीक्षाको लागि आबेदन दिएर परीक्षाको लागी अयोग्य भएमा परिषद् जवाफ देहि हुने छैन
                                        </td>
                                        <td><a href="{{ route('student-exam-apply') }}"><span
                                                    class="btn btn-primary">Apply</span></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if ($user->is_foreign == 1)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Apply Foreign Certificate </h4>
                            <hr />
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tbody>
                                        <tr>
                                            <td>Apply Certificate</td>
                                            <td>यो TSLC तहको नाम दर्ताको लागि मात्र हो | यदि यहाँबाट नाम दर्ता प्रमाणपत्र
                                                परीक्षाको लागि आबेदन दिएर परीक्षाको लागी अयोग्य भएमा परिषद् जवाफ देहि हुने
                                                छैन
                                            </td>
                                            @php
                                                $isForeign = 1; // Set default if $isForeign is not defined
                                            @endphp
                                            <td>
                                                <a href="{{ route('student-foreign-certificate') }}">
                                                    <span class="btn btn-primary">Apply</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
        </div>
    </div>

@endsection
