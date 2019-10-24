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

include_once("header.php");	///loads the html HEAD section (JS,CSS)

?>
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>

<div class="container" style="width:95%;">
    <div class="row" style="margin-top:55px;">
        <div class="col-md-2 ">
            <?php //echo Modules::run('leftmenu/questionnaire'); //runs the available left menu for preferance ?>
            <?php echo Modules::run('leftmenu/preference'); //runs the available left menu for preferance ?>
        </div>
        <div class="col-md-10 ">
            <?php
            if (isset($error)){
                echo '<div class="alert alert-danger"><b>ERROR:</b>'.$error.'</div>';
                exit;
            }
            ?>
            <div class="panel panel-default"  >
                <div class="panel-heading"><b>Generate Report Profiles</b></div>
                <div id='prefCont'>
                    <?php echo $pager; ?>
                </div>
            </div>
        </div>
    </div>
</div>