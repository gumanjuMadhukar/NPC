<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {

        $('#statusModal').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                url: '{{ route("officer-applicant-status")}}',
                type: 'get',
                data: {
                    'id': id
                },
                success: function(data) {
                    $(e.currentTarget).find('#modal-content').html(data);
                }
            });
        });
    });
</script>