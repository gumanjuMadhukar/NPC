<script>
$(document).ready(function() {
    $('.switch-status').change(function() {
        if ($(this).attr('data-status-value') == 0) {
            var val = 1;
        } else {
            var val = 0;
        }
        $(this).attr("data-status-value", val);
        var id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route("officer-municipality-status")}}',
            type: 'POST',
            data: {
                'id': id,
                'val': val,
                'field_name': 'status',
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                toastr["success"](data.message);
            },
            error: function(xhr) {
                var res = $.parseJSON(xhr.responseText);
                if (res.error) {
                    toastr['error'](res.error);
                }
            }
        });
    });
});
</script>
