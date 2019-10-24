<?php

/**
 * Created by PhpStorm.
 * User: kavinga
 * Date: 4/13/14
 * Time: 10:59 AM
 */
class Generate_report extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->checkLogin();
        $this->load->helper('url');
        $this->load->library('session');
        //$this->load->library('MdsCore');
    }

    public function grid()
    {

        $path = 'application/forms/generate_report_profile.php';
        require $path;
        $frm = $form;
        $columns = $frm["LIST"];
        $table = $frm["TABLE"];
        $sql = "SELECT ";

        foreach ($columns as $column) {
            $sql .= $column . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql .= " FROM $table ";
        $this->load->model('mpager');
        $this->mpager->setSql($sql);
        $this->mpager->setDivId('prefCont');
        $this->mpager->setSortorder('asc');
        //set colun headings
        $colNames = array();
        foreach ($frm["DISPLAY_LIST"] as $colName) {
            array_push($colNames, $colName);
        }
        $this->mpager->setColNames($colNames);

        //set captions
        $this->mpager->setCaption($frm["CAPTION"]);
        //set row id
        $this->mpager->setRowid($frm["ROW_ID"]);

        //set column models
        foreach ($frm["COLUMN_MODEL"] as $columnName => $model) {
            if (gettype($model) == "array") {
                $this->mpager->setColOption($columnName, $model);
            }
        }

        //set actions
        $action = $frm["ACTION"];
        $this->mpager->gridComplete_JS = "function() {
            var c = null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='$action/'+rowId;
            });
            }";

        //report starts
        if (isset($frm["ORIENT"])) {
            $this->mpager->setOrientation_EL($frm["ORIENT"]);
        }
        if (isset($frm["TITLE"])) {
            $this->mpager->setTitle_EL($frm["TITLE"]);
        }

//        $pager->setSave_EL($frm["SAVE"]);
        $this->mpager->setColHeaders_EL(isset($frm["COL_HEADERS"]) ? $frm["COL_HEADERS"] : $frm["DISPLAY_LIST"]);
        //report endss

        $data['pager'] = $this->mpager->render(false);
//        $data["pre_page"] = $fName;
        $this->load->vars($data);
        $this->load->view('grid');
//        return "<h1>$sql";
    }

    public function editProfile($profileId = null)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data = array();

        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("name", "Name", "required");
        $this->form_validation->set_rules("enabled", "enabled", "required");

        if ($this->input->post()) {
            $profileId = $this->input->post('profile_id');
            if ($this->form_validation->run() == true) {
                $profile = $this->load->model('mgenerate_report_profile')->load($profileId);

                $profile->name = $this->input->post('name');
                $profile->template = $this->input->post('template');
                $profile->enabled = $this->input->post('enabled');
                $profile->fields = implode(",", $this->input->post('fields'));
                $profile->save();
                header("Status: 200");
                header("Location: " . site_url('generate_report/grid'));
            } else {

            }
        }

        $profile = $this->load->model('mgenerate_report_profile')->load($profileId);
        $data['profile'] = $profile;
        $data['fields'] = $this->load->model('report/entity/' . $profile->entity)->getFields();
        $data['fieldsSelected'] = explode(",", $profile->fields);

        $this->load->vars($data);
        $this->load->view('edit');
    }

} 