@if(count($user->user_qualifications) > 0) 
<div class="col-md-12 col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-qualifications-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-qualifications" type="button" role="tab" aria-controls="nav-qualifications"
                    aria-selected="true">Qualification</button>
            </div>
            <div class="tab-pane fade show active" id="qualifications" role="tabpanel"
                aria-labelledby="qualifications-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Qualification</th>
                                        <th>Level</th>
                                        <th>Board / University</th>
                                        <th>College / Institution / School</th>
                                        <th>Passed Year (B.S. / A.D.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1 @endphp
                                    @foreach($user->user_qualifications as $qualification)
                                        <tr>
                                            <td>{{$count++}}</td>
                                            <td>{{$qualification->level->name}}</td>
                                            <td>{{$qualification->level->short_name_nepali}}</td>
                                            <td>{{$qualification->board_university}}</td>
                                            <td>{{$qualification->college_name}}</td>
                                            <td>{{$qualification->passed_year}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif