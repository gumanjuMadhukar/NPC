<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="info-box">
                <div class="card tab-style1">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs profile-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#abc" role="tab"
                                aria-expanded="true">Certificate History</a> </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!--second tab-->
                        <div class="tab-pane active" id="abc" role="tabpanel" aria-expanded="true">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if ($certificates->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>S.N.</td>
                                                        <td>Program Certificate Code</td>
                                                        <td>Srn</td>
                                                        <td>Cert Registration Number</td>
                                                        <td>Decision Date</td>
                                                    </tr>
                                                </thead>
                                                    <tbody>
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        @foreach ($certificates as $certificate)
                                                            <tr>
                                                                <th>{{ $count }}</th>
                                                                <th>{{ $certificate->program_certificate_code }}</th>
                                                                <th>{{ $certificate->srn_number }}</th>
                                                                <th>{{ $certificate->cert_registration_number }}</th>
                                                                <th>{{ $certificate->decision_date }}</th>
                                                            </tr>
                                                            @php
                                                                $count++;
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                @else
                                                    <div class="alert alert-warning alert-message" role="alert">
                                                        No data found.
                                                    </div>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
