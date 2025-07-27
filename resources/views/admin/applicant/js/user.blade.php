<script>
     function printDiv() {
            var divContents = document.getElementById("print-content");
            var a = window.open('');
            a.document.write(divContents.outerHTML);
            // a.print();
            // a.close();
        }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>