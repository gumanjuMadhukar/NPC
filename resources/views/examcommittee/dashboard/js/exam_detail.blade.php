<script>
    $(document).ready(function() {
        $('.generate-admit-card').click(function(){
            var exam_id = $(this).data('exam_id');
            var program_id = $(this).data('program_id');
            var subject_committee_id = $(this).data('subject_committee_id');
            var level_id = $(this).data('level_id');
            var data = {
                'exam_id' : exam_id,
                'program_id' : program_id,
                'subject_committee_id' : subject_committee_id,
                'level_id' : level_id,
                '_token': '{{ csrf_token() }}'
            }
            
            $.post("{{ route('exam_committee-admitcard-generate') }}", data, function(data){}, 'json');
        });
    });
</script>