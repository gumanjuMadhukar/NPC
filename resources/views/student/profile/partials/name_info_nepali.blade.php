<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">पहिलो नाम *</label>
        <input class="form-control" name="first_name_nep"
            value="{{ $user->info->first_name_nep ?? old('first_name_nep') }}" type="text">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">बिचको नाम</label>

        <input class="form-control" name="middle_name_nep"
            value="{{ $user->info->middle_name_nep ?? old('middle_name_nep') }}" type="text">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">थर *</label>
        <input class="form-control" name="last_name_nep"
            value="{{ $user->info->last_name_nep ?? old('last_name_nep') }}" type="text">
    </div>
</div>
