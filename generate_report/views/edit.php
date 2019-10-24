<?php
/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> or write to:
Free Software  HHIMS
ICT Agency,
160/24, Kirimandala Mawatha,
Colombo 05, Sri Lanka
---------------------------------------------------------------------------------- 
Author: Author: Mr. Jayanath Liyanage   jayanathl@icta.lk
                 
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/

include_once("header.php"); ///loads the html HEAD section (JS,CSS)

?>
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>

<script>
    $(function () {
        function initToolbarBootstrapBindings() {
            var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                    'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                    'Times New Roman', 'Verdana'],
                fontTarget = $('[title=Font]').siblings('.dropdown-menu');
            $.each(fonts, function (idx, fontName) {
                fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
            });
            $('a[title]').tooltip({container: 'body'});
            $('.dropdown-menu input').click(function () {
                return false;
            })
                .change(function () {
                    $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                })
                .keydown('esc', function () {
                    this.value = '';
                    $(this).change();
                });

            $('[data-role=magic-overlay]').each(function () {
                var overlay = $(this), target = $(overlay.data('target'));
                overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
            });
            if ("onwebkitspeechchange"  in document.createElement("input")) {
                var editorOffset = $('#editor').offset();
                $('#voiceBtn').css('position', 'absolute').offset({top: editorOffset.top, left: editorOffset.left + $('#editor').innerWidth() - 35});
            } else {
                $('#voiceBtn').hide();
            }
        };
        function showErrorAlert(reason, detail) {
            var msg = '';
            if (reason === 'unsupported-file-type') {
                msg = "Unsupported format " + detail;
            }
            else {
                console.log("error uploading file", reason, detail);
            }
            $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        };
        initToolbarBootstrapBindings();
        $('#editor').wysiwyg({ fileUploadError: showErrorAlert});
        window.prettyPrint && prettyPrint();
    });
</script>
<style>

    #editor {
        max-height: 250px;
        height: 250px;
        background-color: white;
        border-collapse: separate;
        border: 1px solid rgb(204, 204, 204);
        padding: 4px;
        box-sizing: content-box;
        -webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
        box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
        border-top-right-radius: 3px; border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px; border-top-left-radius: 3px;
        overflow: scroll;
        outline: none;
    }
    #voiceBtn {
        width: 20px;
        color: transparent;
        background-color: transparent;
        transform: scale(2.0, 2.0);
        -webkit-transform: scale(2.0, 2.0);
        -moz-transform: scale(2.0, 2.0);
        border: transparent;
        cursor: pointer;
        box-shadow: none;
        -webkit-box-shadow: none;
    }

    div[data-role="editor-toolbar"] {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .dropdown-menu a {
        cursor: pointer;
    }
</style>
<div class="container" style="width:95%;">
    <div class="row" style="margin-top:55px;">
        <div class="col-md-2 ">
            <?php //echo Modules::run('leftmenu/questionnaire'); //runs the available left menu for preferance ?>
            <?php echo Modules::run('leftmenu/preference'); //runs the available left menu for preferance ?>
        </div>
        <div class="col-md-10 ">
            <?php
            if (isset($error)) {
                echo '<div class="alert alert-danger"><b>ERROR:</b>' . $error . '</div>';
                exit;
            }
            ?>
            <?php echo form_open('generate_report/editProfile', '', array('profile_id' => $profile->profile_id)); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><b>Edit Profile</b></div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general_configuration" data-toggle="tab">General Configuration</a></li>
                    <li><a href="#report_fields" data-toggle="tab">Report Fields</a></li>
                    <li><a href="#output_format" data-toggle="tab">Output Format</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="general_configuration">
                        <br/>

                        <div class="form-group">
                            <div class="row">
                                <div style="width:220px;" class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right" for="name">*Name</label>
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    <input type="text" rules="trim|required|xss_clean" style="" placeholder="Name"
                                           value="<?php echo set_value('name', $profile->name) ?>" name="name" id="name"
                                           class="form-control input-sm">
                                    <?php echo form_error('name'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div style="width:220px;" class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right" for="type">*Type</label>
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    <input type="text" rules="trim|required|xss_clean" readonly
                                           value="<?php echo set_value('entity', $profile->entity) ?>" name="type"
                                           id="type"
                                           class="form-control input-sm">
                                    <?php echo form_error('entity'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div style="width:220px;" class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right" for="enabled">*Enabled</label>
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    <select name="enabled" id="enabled" class="form-control input-sm">
                                        <option value="0" <?php if (set_value('enabled', $profile->enabled) == 0) {
                                            echo 'selected';
                                        } ?> >No
                                        </option>
                                        <option value="1" <?php if (set_value('enabled', $profile->enabled) == 1) {
                                            echo 'selected';
                                        } ?>>Yes
                                        </option>
                                    </select>
                                    <?php echo form_error('enabled'); ?>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane" id="report_fields">
                        <br/>

                        <div class="form-group">
                            <div class="row">
                                <div style="width:220px;" class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right" for="patient">Patient</label>
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    <?php
                                    $html = '';
                                    foreach ($fields as $field => $val) {
                                        if (isset($val['al'])) {
                                            $value = $val['al'];
                                        } else {
                                            $value = $val['qf'];
                                        }
                                        $selected = '';
                                        if (in_array($value, $fieldsSelected)) {
                                            $selected = 'checked';
                                        }
                                        $html .= '<div class="checkbox">';
                                        $html .= '<label><input type="checkbox" value="' . $value . '" name="fields[]" '
                                            . $selected . '>'
                                            . $field . '</label>';
                                        $html .= '</div>';
                                    }
                                    echo $html;
                                    ?>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane" id="output_format">
                        <br/>
                        <div class="row">
                            <div style="width:220px;" class="col-xs-3 col-md-3">
                                <label class="control-label pull-right" for="enabled">Template</label>
                            </div>
                            <div class="col-xs-8 col-md-8">
                                <textarea class="form-control" rows="15" name="template" ><?php echo set_value('template',$profile->template) ?></textarea>
                                <?php echo form_error('template'); ?>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-3 col-md-3"></div>
                    <button type="submit" name="Save" id="SaveBtn" value="Save" class="btn btn-primary "><span
                            class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                    &nbsp;<input type="button" name="Cancel" value="Cancel" id="Cancel" class="btn btn-default"
                                 onclick="go_cancel()"><br><br></div>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>
</div>