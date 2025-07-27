@extends('student.layout')
@section('content')
    @include('common.admitcard.admit_card')
@endsection

@section('footer-scripts')
    <script>
        // document.getElementById("printBtn").addEventListener("click", function() {
        //     var printDiv = document.getElementById('print-content').innerHTML;
        //     document.body.innerHTML = printDiv;
        //     window.print();
        //     document.body.innerHTML = allContent;
        // });

        function printDiv() {
            var divContents = document.getElementById("print-content");
            var a = window.open('');
            a.document.write(divContents.outerHTML);
            // a.print();
            // a.close();
        }
    </script>
@endsection
