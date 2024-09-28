$(document).ready(function(){
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 70,
        format: 'yyyy-mm-dd',
        max: true,
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