$(document).ready(function(){
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15,
        format: 'yyyy-mm-dd',
        onClose: function(){
            // เมื่อ datepicker ถูกปิด (หลังจากเลือกวันที่)
            if(this.get('select')) {
                // ถ้ามีการเลือกวันที่
                $('label[for="' + this.$node.attr('id') + '"]').addClass('active');
            }
        }
    });

    $('input.autocomplete').autocomplete({
        data: {
            "Apple": null,
            "Microsoft": null,
            "Google": 'assets/images/google.png'
        }
    });
});