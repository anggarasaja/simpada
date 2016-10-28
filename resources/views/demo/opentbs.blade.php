<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OpenTBS Demo</title>
<script language="javascript">
  // redirection if open without the menu at the TBS site
  if ( (document.location.href.indexOf('www.tinybutstrong.com') > 0)
        && (document.location.href.indexOf('demo.html') > 0)
	  ) {
  	document.location.href = "/opentbs.php?demo";
  }
</script>
<script type="text/javascript">
	function download_template() {
		var file = document.forms['form1'].elements['tpl'].value;
		var rep = document.forms['form1'].action;
		var p = rep.lastIndexOf('/');
		if (p>=0) {
			file = rep.substr(0, p+1) + file
		}
		window.location.href = file;
	}
</script>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
.title1 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style></head>

<body>
<!-- main-body is used for insertion in the TBS menu -->
<div id="main-body">
<p align="center"><span class="title1">OpenTBS</span> <span class="title1">demo</span><br />
  OpenTBS is a PHP tool that produces any OpenOffice and Ms Office documents with the technic of template<br />
  <br />
</p>
<h2>Presentation</h2>
<p>OpenTBS can merge any OpenDocument and Open XML  files. It autommatically reconize extensions: <strong>odt</strong>, <strong>ods</strong>, <strong>odg</strong>, <strong>odf</strong>, <strong>odm</strong>, <strong>odp</strong>, <strong>ott</strong>, <strong>ots</strong>, <strong>otg</strong>, <strong>otp</strong>, <strong>docx</strong>, <strong>xlsx, xlsm</strong>, <strong>pptx</strong>.</p>
<p> In fact it can merge any XML or Text file saved in a zip container (which is the case for both OpenDocuments and OpenXML documents).</p>
<p><span id="result_box" lang="en" xml:lang="en">In addition to the usual merging operations, m</span>any other oprerations can be done on documents, such as: feed a table, delete or display paragraphs, change pictures, delete sheets, change data in graphs, ... and much more.</p>
<h2>Characteristics</h2>
<ul>
  <li> No temporary files needed.</li>
  <li> Creates a new document directly as a download, a physical file, or a binary PHP string.</li>
  <li> Works with both PHP 4 and PHP 5.</li>
  <li> No PHP extension required (but easier to use if <a href="http://www.php.net/manual/en/book.zlib.php">ZLib</a> is enabled)</li>
</ul>
<h2>Demo</h2>
<form id="form1" method="post" action="/demo-opentbs/download">
  <table border="0" cellspacing="4" cellpadding="0">
    <tr>
      <td scope="col">Enter a name :</td>
      <td scope="col"><input name="yourname" type="text" size="10" /> <i>(will be displayed in the merged result)</i></td>
    </tr>
    <tr>
      <td>Choose a template :</td>
      <td><select name="tpl">
        <option value="demo_oo_text.odt">OpenOffice Writer Document (.odt)</option>
        <option value="demo_oo_spreadsheet.ods">OpenOffice Calc Spreadsheet (.ods)</option>
        <option value="demo_oo_presentation.odp">OpenOffice Impress Presentation (.odp)</option>
        <option value="demo_oo_graph.odg">OpenOffice Draw Graphic (.odg)</option>
        <option value="demo_oo_formula.odf">OpenOffice Math Formula (.odf)</option>
        <option value="demo_ms_word.docx">Ms Word Document (.docx)</option>
        <option value="demo_ms_excel.xlsx">Ms Excel SpreadSheet (.xlsx)</option>
        <option value="demo_ms_powerpoint.pptx">Ms PowerPoint Presentation (.pptx)</option>
      </select></td>
    </tr>
    <tr>
      <td>Debug :</td>
      <td><select name="debug">
        <option value="" selected="selected">No</option>
        <option value="info">General Information</option>
        <option value="current">During merge</option>
        <option value="show">After merge</option>
      </select></td>
    </tr>
    <tr id="save_as_file" style="display:none;">
      <td>Save locally with suffix :</td>
      <td><input name="save_as" type="text" size="10" /> <i>(leave empty for direct download)</i></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
	    <input type="submit" name="btn_result" value="Merge" />
	    <!-- <input type="submit" name="btn_template" value="See template" /> -->
	    <!-- <input type="submit" name="btn_script" value="See PHP script" /> -->
	  </td>
    </tr>
  </table>
</form>

<h2>More</h2>
<ul>
  <li> OpenTBS help file : <a href="http://www.tinybutstrong.com/plugins/opentbs/tbs_plugin_opentbs.html">tbs_plugin_opentbs.html</a></li>
  <li>  Discover the <a href="http://www.tinybutstrong.com">TinyButStrong</a> template engine for PHP</li>
  <li> Go to <a href="http://www.tinybutstrong.com/plugins.php">OpenTBS download</a> page </li>
</ul>
</body>
<script type="text/javascript">
	// enable the option for savegin as a file, the PHP script will test if it is running on localhost anyway.
	if (window.location.hostname=='localhost') document.getElementById('save_as_file').style.display='table-row';
</script>
</div>
</html>