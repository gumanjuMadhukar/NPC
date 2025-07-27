<div class="content">
    <div class="container-fluid">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="{{$action}}" id="form">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="{{ ($row) ? $row->id : 0 }}">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ ($row) ? $row->name : old('name')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <select class="form-control select2" name="level_id">
                                @if($levels->count() > 0)
                                @foreach($levels as $level)
                                <option value="{{$level->id}}" @if($row && $row->level_id == $level->id)
                                    selected @endif>{{$level->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="text" class="form-control" name="amount"
                                value="{{ ($row) ? $row->amount : old('amount')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" name="description"
                                value="{{ ($row) ? $row->description : old('description')}}">
                        </div>
                        <div class="mb-3">
                            <label class="col-sm-12">Select College Type</label>
                            <div class="col-sm-12">
                                <select class="form-control form-control-line" name="college_type">
                                    <option value="national">National</option>
                                    <option value="international">International</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="status" value="1"
                                            {{ ($row && $row->status == 1) ||  (!$row) ? 'checked' : '' }} /> <span
                                            class="switch-label" data-on="Show" data-off="Hide"></span>
                                        <span class="switch-handle"></span> </label>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
