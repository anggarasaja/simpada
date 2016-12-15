<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\bank;
use App\Libraries\tbs_class;
use App\Libraries\tbs_plugin_opentbs;
class Pendaftaran extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    ### PRIBADI ###

    public function wpwrpribadi(){
        return view('pendaftaranwpwrpribadi');
    }

    public function show_wpwrpribadi(){
        return view('show_wpwrpribadi');
    }

    public function store_wpwrpribadi(){

    }

    ### BADAN USAHA  ####

    public function wpwrbadan(){
        return view('wpwrbadan');
    }

    public function show_wpwrbadan(){
        return view('show_wpwrbadan');
    }

    public function store_wpwrbadan(){

    }

    ### CETAK KARTU ####

    public function cetak_kartu(){
        return view('cetak_kartu');
    }
    public function cetak_npwpd(){
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

        $data = array();
        $template = app_path() . '/Doc_Template/npwpd.docx';
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
        // $TBS->MergeBlock('a,b', $data);

        // Merge data in colmuns
        $data = array(
         array('date' => '2013-10-13', 'thin' => 156, 'heavy' => 128, 'total' => 284),
         array('date' => '2013-10-14', 'thin' => 233, 'heavy' =>  25, 'total' => 284),
         array('date' => '2013-10-15', 'thin' => 110, 'heavy' => 412, 'total' => 130),
         array('date' => '2013-10-16', 'thin' => 258, 'heavy' => 522, 'total' => 258),
        );
        $TBS->MergeBlock('c', $data);


    
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
}
