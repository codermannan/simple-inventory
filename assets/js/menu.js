            $(function() {
                $('input.tip, select.tip').tooltip({placement: "right", trigger: "focus"});
                $('.tip').tooltip();
                $(".chzn-select").on("liszt:showing_dropdown", function() {
                    $(this).parents("div").css("overflow", "visible");
                });
                $(".chzn-select").on("liszt:hiding_dropdown", function() {
                    $(this).parents("div").css("overflow", "");
                });
                <?php if (THEME == 'rtl') { ?>
                    $(".chzn-container, form select").addClass('chzn-rtl');
                <?php } ?>
                $("form select").chosen({no_results_text: "<?php echo $this->lang->line('no_results_matched'); ?>", disable_search_threshold: 5, allow_single_deselect: true});
                $('#note').redactor({
                    buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'image', 'video', 'link', '|', 'html'],
                    formattingTags: ['p', 'pre', 'h3', 'h4'],
                    imageUpload: '<?php echo site_url('module=home&view=image_upload'); ?>',
                    imageUploadErrorCallback: function(json)
                    {
                        bootbox.alert(json.error);
                    },
                    minHeight: 100
                });
                $('#internal_note').redactor({
                    buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'image', 'video', 'link', '|', 'html'],
                    formattingTags: ['p', 'pre', 'h3', 'h4'],
                    imageUpload: '<?php echo site_url('module=home&view=image_upload'); ?>',
                    imageUploadErrorCallback: function(json)
                    {
                        bootbox.alert(json.error);
                    },
                    minHeight: 100,
                    placeholder: '<?php echo $this->lang->line('internal_note'); ?>'
                });
                $('.redactor_toolbar a').tooltip({container: 'body'});
                $('.showSubMenus').click(function() {
                    var sub_menu = $(this).attr('href');
                    $('.sub-menu').slideUp('fast');
                    $('.menu').find("b").removeClass('caret-up').addClass('caret');

                    if ($(sub_menu).is(":hidden")) {
                        $(sub_menu).slideDown("slow");
                        $(this).find("b").removeClass('caret').addClass('caret-up');
                    } else {
                        $(sub_menu).slideUp();
                        $(this).find("b").removeClass('caret-up').addClass('caret');
                    }
                    return false;
                });
                $('.menu-collapse').click(function() {
                    $('#col_1').slideToggle();
                });

            });
            $(window).resize(function() {
                if ($(document).width() > 980) {
                    $('#col_1').show();
                }
            });