var KTFormRepeater = {
    init: function() {
        $("#kt_repeater_1").repeater({
            initEmpty: !1,
            defaultValues: {
                "text-input": "foo"
            },
            show: function() {
                $(this).slideDown()
            },
            hide: function(e) {
                $(this).slideUp(e)
            }
        }),
            $("#kt_repeater_2").repeater({
                initEmpty: !1,
                defaultValues: {
                    "text-input": "foo"
                },
                show: function() {
                    $(this).slideDown()
                },
                hide: function(e) {
                    confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
                }
            }),
            $("#kt_repeater_3").repeater({
                initEmpty: !1,
                defaultValues: {
                    "text-input": "foo"
                },
                show: function() {
                    $(this).slideDown()
                },
                hide: function(e) {
                    confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
                }
            }),
            $("#kt_repeater_4").repeater({
                initEmpty: !1,
                defaultValues: {
                    "text-input": "foo"
                },
                show: function() {
                    $(this).slideDown()
                },
                hide: function(e) {
                    $(this).slideUp(e)
                }
            }),
            $("#kt_repeater_5").repeater({
                initEmpty: !1,
                defaultValues: {
                    "text-input": "foo"
                },
                show: function() {
                    $(this).slideDown()
                },
                hide: function(e) {
                    $(this).slideUp(e)
                }
            }),
            $("#kt_repeater_6").repeater({
                initEmpty: !1,
                defaultValues: {
                    "text-input": "foo"
                },
                show: function() {
                    $(this).slideDown()
                },
                hide: function(e) {
                    $(this).slideUp(e)
                }
            })
    }
};
jQuery(document).ready(function() {
    KTFormRepeater.init()
});
$("#kt_dropzone_2").dropzone({
    url: "https://keenthemes.com/scripts/void.php",
    paramName: "file",
    maxFiles: 10,
    maxFilesize: 10,
    addRemoveLinks: !0,
    accept: function(e, o) {
        "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o()
    }

});

