<div class="container-fluid" id="dashboard">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3>Exam Details</h3>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Name</th>
                                    <th>Opening Date</th>
                                    <th>Closing Date</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result['exams'] as $exam)
                                    <tr>
                                        <td>{{ $result['count']++ }}</td>
                                        <td>{{ $exam->name }}</td>
                                        <td>{{ $exam->opening_date }}</td>
                                        <td>{{ $exam->closing_date }}</td>
                                        <td>{{ $exam->created_at }}</td>
                                        <td>
                                            @php
                                            // Dynamically generate the route name based on the user's role
                                            $routePrefix = strtolower($user); // Convert user role to lowercase if needed
                                            $routeName = $routePrefix . '-dashboard-exam-detail'; // Example: admin-dashboard-exam-detail
                                        @endphp
                                        <a href="{{ route($routeName, $exam->id) }}" class="btn text-primary" title="View" data-bs-toggle="tooltip"
                                            data-bs-placement="top">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        </td>
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
