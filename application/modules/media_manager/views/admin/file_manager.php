<?php
// Heading
$heading_title   = 'Media Manager';

// Text
$text_uploaded   = 'Success: Your file has been uploaded!';
$text_directory  = 'Success: Directory created!';
$text_delete     = 'Success: Your file or directory has been deleted!';

// Entry
$entry_search    = 'Search..';
$entry_folder    = 'Folder Name';

// Error
$error_permission= 'Warning: Permission Denied!';
$error_filename  = 'Warning: Filename must be a between 3 and 255!';
$error_folder    = 'Warning: Folder name must be a between 3 and 255!';
$error_exists    = 'Warning: A file or directory with the same name already exists!';
$error_directory = 'Warning: Directory does not exist!';
$error_filetype  = 'Warning: Incorrect file type!';
$error_upload    = 'Warning: File could not be uploaded for an unknown reason!';
$error_delete    = 'Warning: You can not delete this directory!';
$button_parent   = 'parent button';
$parent          = 'hrefLinkNeedToSet';
$button_upload   = 'button upload';
$button_folder   = 'button folder';
$button_delete   = 'button delete';
$button_refresh  = 'button refresh';
$refresh         = 'refresh';
$filter_name     = 'filter name';
$button_search   = 'button search';
$images = array();
?>

<div id="file_manager_modal" data-featherlight="#mylightbox" class="modal-dialog modal-lg file-manager" >
    <div class="modal-content file-manager-content">
        <div class="modal-header">
            <h4 class="modal-title"><?php echo $heading_title; ?></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-5">
                    <input id="current_path" type="hidden" path="<?php echo $current_path; ?>" />
                    <a href="javascript: void(0)" data-toggle="tooltip" path="<?php echo $current_path; ?>" title="<?php echo $button_parent; ?>" id="button-parent" class="btn btn-default level_up_icon center-bg"><i class="fa fa-level-up"></i></a>
                    <a href="javascript: void(0)" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" path="<?php echo $current_path; ?>" id="button-refresh" class="btn btn-default refresh_icon center-bg"><i class="fa fa-refresh"></i></a>
                    <button type="button" data-toggle="tooltip" title="<?php echo $button_upload; ?>" id="button-upload" class="btn btn-primary upload_icon center-bg"><i class="fa fa-upload"></i></button>
                    <!--<button type="button" data-toggle="tooltip" title="<?php //echo $button_folder; ?>" id="button-folder" class="btn btn-default folder_icon center-bg"><i class="fa fa-folder"></i></button>-->
                    <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="button-delete" class="btn btn-danger trash_icon center-bg"><i class="fa fa-trash-o"></i></button>
                </div>
            </div>
            <div id="myId"></div>
            <hr />
            <?php foreach (array_chunk($vars['images'], 4) as $image) { ?>
                <div class="row">
                    <?php foreach ($image as $key => $image) { ?>
                        <div class="col-sm-3 text-center">
                            <?php if ($image['type'] == 'directory') { ?>
                                <li path="<?php echo $image['href']; ?>" class="text-center folder_icon center-bg-big-image"></li>
                                <label><?php echo $image['name']; ?></label>
                            <?php } ?>
                            <?php if ($image['type'] == 'image') { ?>
                                <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
                                <label>
                                    <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
                                    <?php echo $image['name']; ?></label>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <br />
            <?php } ?>
        </div>
        <!--<div class="modal-footer"><?php // echo $pagination; ?></div>-->
    </div>
</div>

<script>
    var imageManagerPopupCommands = (function($) {  // Image Manager module
        config = {
            ajaxLoader: '<img src="/assets/img/ajax-loader.gif" />',
            ajaxLoaderWhite: '<img src="/assets/img//ajax-loader-white-transparent.gif" />',
        };

        function init() {
            initImageManagerPopupButtons();
        }

        function initImageManagerPopupButtons(){
            /*
            $('#button-folder').popover({
                html: true,
                placement: 'bottom',
                trigger: 'click',
                title: 'Folder Name',
                content: function() {
                    html  = '<div class="input-group">';
                    html += '  <input type="text" name="folder" value="" placeholder="Folder Name" class="form-control">';
                    html += '  <span class="input-group-btn"><button type="button" title="button folder" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
                    html += '</div>';

                    return html;
                }
            });
            $('#button-folder').click(function(e) {
                e.stopPropagation();
                var selectedPath = $(this).find('a:first').attr('href');

                image_manager_refresh(selectedPath);
            });
            */
            $('#button-refresh').click(function(e) {
                e.stopPropagation();
                var selectedPath = $(this).attr("path");
                image_manager_refresh(selectedPath);
            });

            $('#button-parent').click(function(e) {
                e.stopPropagation();
                var selectedPath = $(this).attr("path");
                selectedPath = selectedPath.substring(0, selectedPath.length - 1);
                selectedPath = selectedPath.substring(0, selectedPath.lastIndexOf('/'));
                image_manager_refresh(selectedPath);
            });

            $('.folder_icon').click(function() {
                var selectedPath = $(this).attr("path");
                console.log(selectedPath);
                image_manager_refresh(selectedPath);
            });
        }

        /*
        function create_folder(){
            $('#button-folder').on('shown.bs.popover', function() {
                $('#button-create').on('click', function() {
                    $.ajax({
                        url: '',
                        type: 'post',
                        dataType: 'json',
                        data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
                        beforeSend: function() {
                            $('#button-create').prop('disabled', true);
                        },
                        complete: function() {
                            $('#button-create').prop('disabled', false);
                        },
                        success: function(json) {
                            if (json['error']) {
                                alert(json['error']);
                            }

                            if (json['success']) {
                                alert(json['success']);

                                $('#button-refresh').trigger('click');
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                });
            });
        }
        */

        function image_manager_refresh(selectedPath){
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('/admin/media_manager/index');?>',
                data: 'selectedPath=' + selectedPath,
                dataType: 'json',
                beforeSend: function() {
                    console.log('image_manager_refresh is being executed.');
                    $('#ajaxLoaderWhite').html(config.ajaxLoaderWhite);
                    $('#ajaxLoaderWhite').css('display', 'block');
                },
                complete: function() {
                    $('#ajaxLoaderWhite').css('display', 'none');
                    $('#ajaxLoaderWhite').html('');
                    var myDropzone = new Dropzone("div#myId", { url: "/file/post"});
                },
                success: function(data) {
                    if (typeof(data.error_warning) != 'undefined' && data.error_warning !== null){
                        if(data.error_warning == ''){  // if User successfully logged in.
                            // display account related links
                            console.log('Display Media Content - no errors were found.');
                            var file_manager_html = data.html;
                            $("#adminMediaPopup").fancybox({content:file_manager_html}).click();
                        }else{
                            $('#ajaxLoginErrorMessage').html(data.error_warning)
                            $('#ajaxLoginErrorMessageBox').removeClass('hidden');
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        return {
            init: init
        };
    })(jQuery);

    jQuery(document).ready(function ($) {  // Loading the js modules.
        imageManagerPopupCommands.init();
    });
</script>
