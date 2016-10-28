<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Libraries\tbs_class;
use App\Libraries\tbs_plugin_opentbs;
// include_once(app_path() . '/Libraries/clsTinyButStrong.php');
// include_once(app_path() . '/Libraries/tbs_plugin_opentbs.php')  ;
class opentbsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('demo.opentbs');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getFile(){
        // Retrieve the template to open
        $template = (isset($_POST['tpl'])) ? $_POST['tpl'] : '';
        $name = $_POST['yourname'];
        $template = basename($template); // for security
        $info= pathinfo($template);
        $script = $info['filename'].'.php';
        $exploded = explode('.', $template);
        $type = $exploded[1];
        // print_r(explode('.', $template));
        // print_r($_POST);
        // echo $name;
        // exit;

        // if (substr($template,0,5)!=='demo_') exit("Wrong file.");
        if (!file_exists(app_path() . '/Doc_Template/'.$template)) exit("The asked template does not exist.");

        if (isset($_POST['btn_template'])) {
            header('Location: '.$template); 
            exit;
        }

        if (isset($_POST['btn_script'])) {
            f_source($script);
            exit;
        }

        // Start the demo
        if (isset($_POST['btn_result'])) {
            switch ($type){
                case 'odt':
                    $this->getOdt($name);
                    break;
                case 'ppt':
                    $this->getPpt($name);
                    break;
                case 'xlsx':
                    $this->getXlxs($name);
                    break;
                case 'ods':
                    $this->getOds($name);
                    break;
                case 'odp':
                    $this->getOdp($name);
                    break;
                case 'odg':
                    $this->getOdg($name);
                    break;
                case 'odf':
                    $this->getOdf($name);
                    break;
                case 'docx':
                    $this->getDoc($name);
                    break;
                default:exit;

            }
            // include($script);
            // exit;
        }

    }

    protected function getPpt($name){

        // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        // ------------------------------
        // Prepare some data for the demo
        // ------------------------------

        // Retrieve the user name to display
        $yourname = (isset($name)) ? $name : '';
        $yourname = trim(''.$yourname);
        if ($yourname=='') $yourname = "(no name)";

        // A recordset for merging tables
        $data = array();
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13,0,0,2,15,2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // -----------------
        // Load the template
        // -----------------

        $template = app_path() . '/Doc_Template//Doc_Template/demo_ms_powerpoint.pptx';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Select slide #2
        $TBS->Plugin(OPENTBS_SELECT_SLIDE, 2);  
        // Change a picture using the command (it can also be done at the template side using parameter "ope=changepic")
        $TBS->Plugin(OPENTBS_CHANGE_PICTURE, '#merge_me#', app_path() . '/Doc_Template/'.'pic_1234f.png', array('unique' => 1));

        // Merge a chart
        $ChartRef = 'my_chart'; // Title of the shape that embeds the chart
        $SeriesNameOrNum = 1;
        $NewValues = array( array('Cat. A','Cat. B','Cat. C','Cat. D'), array(0.7, 1.0, 3.2, 4.8) );
        $NewLegend = "Merged";
        $TBS->PlugIn(OPENTBS_CHART, $ChartRef, $SeriesNameOrNum, $NewValues, $NewLegend);

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
    }

    protected function getOdt($name){

        // include_once app_path() . '/Libraries/tbs_plugin_opentbs.php';
        // prevent from a PHP configuration problem when using mktime() and date() 
        if (version_compare(PHP_VERSION,'5.1.0')>=0) { 
            if (ini_get('date.timezone')=='') { 
                date_default_timezone_set('UTC'); 
            } 
        } 

        // Initialize the TBS instance 
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS 
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin 

        // ------------------------------ 
        // Prepare some data for the demo 
        // ------------------------------ 

        // Retrieve the user name to display 
        $yourname = $name; 
        // echo $yourname;

        $yourname = trim(''.$yourname); 
        // echo $yourname;

        if ($yourname=='') $yourname = "(no name)"; 
        // echo $yourname;
        // exit;
        // A recordset for merging tables 
        $data = array(); 
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items 
        $x_num = 3152.456; 
        $x_pc = 0.2567; 
        $x_dt = mktime(13,0,0,2,15,2010); 
        $x_bt = true; 
        $x_bf = false; 
        $x_delete = 1; 

        // ----------------- 
        // Load the template 
        // ----------------- 

        $template = app_path() . '/Doc_Template/demo_oo_text.odt'; 
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document). 

        // ---------------------- 
        // Debug mode of the demo 
        // ---------------------- 
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit. 
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit. 
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit. 

        // -------------------------------------------- 
        // Merging and other operations on the template 
        // -------------------------------------------- 

        // Merge data in the body of the document 
        $TBS->MergeBlock('a,b', $data); 

        // Change chart series 
        $ChartNameOrNum = 'a nice chart'; // Title of the shape that embeds the chart 
        $SeriesNameOrNum = 'Series 2'; 
        $NewValues = array( array('Category A','Category B','Category C','Category D'), array(3, 1.1, 4.0, 3.3) ); 
        $NewLegend = "Updated series 2"; 
        $TBS->PlugIn(OPENTBS_CHART, $ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend); 

        // Delete comments 
        $TBS->PlugIn(OPENTBS_DELETE_COMMENTS); 

        // ----------------- 
        // Output the result 
        // ----------------- 

        // Define the name of the output file 
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template); 
        if ($save_as==='') { 
            // Output the result as a downloadable file (only streaming, no data saved in the server) 
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields. 
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data. 
            exit(); 
        } else { 
            // Output the result as a file on the server. 
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields. 
            // The script can continue. 
            exit("File [$output_file_name] has been created."); 
        }
    }

    public function getDoc($name){

        
        // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        // ------------------------------
        // Prepare some data for the demo
        // ------------------------------

        // Retrieve the user name to display
        $yourname = (isset($name)) ? $name : '';
        $yourname = trim(''.$yourname);
        if ($yourname=='') $yourname = "(no name)";
        // print_r(array_keys($GLOBALS['GLOBALS']));
        // A recordset for merging tables
        $data = array();
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13,0,0,2,15,2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // -----------------
        // Load the template
        // -----------------

        $template = app_path() . '/Doc_Template/demo_ms_word.docx';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Merge data in the body of the document
        $TBS->MergeBlock('a,b', $data);

        // Merge data in colmuns
        $data = array(
         array('date' => '2013-10-13', 'thin' => 156, 'heavy' => 128, 'total' => 284),
         array('date' => '2013-10-14', 'thin' => 233, 'heavy' =>  25, 'total' => 284),
         array('date' => '2013-10-15', 'thin' => 110, 'heavy' => 412, 'total' => 130),
         array('date' => '2013-10-16', 'thin' => 258, 'heavy' => 522, 'total' => 258),
        );
        $TBS->MergeBlock('c', $data);


        // Change chart series
        $ChartNameOrNum = 'a nice chart'; // Title of the shape that embeds the chart
        $SeriesNameOrNum = 'Series 2';
        $NewValues = array( array('Category A','Category B','Category C','Category D'), array(3, 1.1, 4.0, 3.3) );
        $NewLegend = "Updated series 2";
        $TBS->PlugIn(OPENTBS_CHART, $ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend);

        // Delete comments
        $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
    }

    protected function getOdf($name){

        

        // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        // ------------------------------
        // Prepare some data for the demo
        // ------------------------------

        // Retrieve the user name to display
        $yourname = (isset($name)) ? $name : '';
        $yourname = trim(''.$yourname);
        if ($yourname=='') $yourname = "(no name)";

        // A recordset for merging tables
        $data = array();
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13,0,0,2,15,2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // -----------------
        // Load the template
        // -----------------

        $template = app_path() . '/Doc_Template/demo_oo_formula.odf';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Merge data
        $TBS->MergeBlock('a,b', $data);

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
    }

    protected function getOdg($name){
        

        // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        // ------------------------------
        // Prepare some data for the demo
        // ------------------------------

        // Retrieve the user name to display
        $yourname = (isset($name)) ? $name : '';
        $yourname = trim(''.$yourname);
        if ($yourname=='') $yourname = "(no name)";

        // A recordset for merging tables
        $data = array();
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13,0,0,2,15,2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // -----------------
        // Load the template
        // -----------------

        $template = app_path() . '/Doc_Template/demo_oo_graph.odg';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Merge data
        $TBS->MergeBlock('a,b', $data);

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
    }

    protected function getOdp($name){

        

        // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        // ------------------------------
        // Prepare some data for the demo
        // ------------------------------

        // Retrieve the user name to display
        $yourname = (isset($name)) ? $name : '';
        $yourname = trim(''.$yourname);
        if ($yourname=='') $yourname = "(no name)";

        // A recordset for merging tables
        $data = array();
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13,0,0,2,15,2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // -----------------
        // Load the template
        // -----------------

        $template = app_path() . '/Doc_Template/demo_oo_presentation.odp';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Merge data in a table (there is no need to select the slide with an ODP)
        $TBS->MergeBlock('b', $data);

        // Hide a slide
        $TBS->PlugIn(OPENTBS_DISPLAY_SLIDES, 'slide to hide', false);

        // Delete a slide
        $TBS->PlugIn(OPENTBS_DELETE_SLIDES, 'slide to delete');

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
    }

    protected function getOds($name){

        

        // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        // ------------------------------
        // Prepare some data for the demo
        // ------------------------------

        // Retrieve the user name to display
        $yourname = (isset($name)) ? $name : '';
        $yourname = trim(''.$yourname);
        if ($yourname=='') $yourname = "(no name)";

        // A recordset for merging tables
        $data = array();
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13,0,0,2,15,2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // -----------------
        // Load the template
        // -----------------

        $template = app_path() . '/Doc_Template/demo_oo_spreadsheet.ods';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Merge data in the Workbook (all sheets)
        $TBS->MergeBlock('a,b', $data);

        // Merge data in Sheet 2
        // No need to change the current sheet, they are all stored in the same XML subfile.
        $TBS->MergeBlock('cell1,cell2', 'num', 3);
        $TBS->MergeBlock('b2', $data);

        // Delete a sheet
        $TBS->PlugIn(OPENTBS_DELETE_SHEETS, 'Delete me');

        // Display a sheet (make it visible)
        $TBS->PlugIn(OPENTBS_DISPLAY_SHEETS, 'Display me');

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
    }

    protected function getXlxs($name){

        // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        // ------------------------------
        // Prepare some data for the demo
        // ------------------------------

        // Retrieve the user name to display
        $yourname = (isset($name)) ? $name : '';
        $yourname = trim(''.$yourname);
        if ($yourname=='') $yourname = "(no name)";

        // A recordset for merging tables
        $data = array();
        $data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
        $data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
        $data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

        // Other single data items
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13,0,0,2,15,2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // -----------------
        // Load the template
        // -----------------

        $template = app_path() . '/Doc_Template/demo_ms_excel.xlsx';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Merge data in the first sheet
        $TBS->MergeBlock('a,b', $data);

        // Merge cells (extending columns)
        $TBS->MergeBlock('cell1,cell2', $data);

        // Change the current sheet
        $TBS->PlugIn(OPENTBS_SELECT_SHEET, 2);

        // Merge data in Sheet 2
        $TBS->MergeBlock('cell1,cell2', 'num', 3);
        $TBS->MergeBlock('b2', $data);

        // Merge pictures of the current sheet
        $x_picture = app_path() . '/Doc_Template/'.'pic_1523d.gif';
        $TBS->PlugIn(OPENTBS_MERGE_SPECIAL_ITEMS);

        // Delete a sheet
        $TBS->PlugIn(OPENTBS_DELETE_SHEETS, 'Delete me');


        // Display a sheet (make it visible)
        $TBS->PlugIn(OPENTBS_DISPLAY_SHEETS, 'Display me');

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
    }
}
