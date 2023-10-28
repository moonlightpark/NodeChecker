<?php
require $_SERVER['DOCUMENT_ROOT'].'/classes/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/classes/Util.php';

$util = new Util();

$up_url= CONT_UP_IMG_URL; //기본업로드 URL
$up_dir= CONT_UP_IMG_DIR; //기본업로드 폴더

//업로드 D
$funcNum = $_GET['CKEditorFuncNum'];
$CKEditor = $_GET['CKEditor'];
$langCode = $_GET['langCode'];

$util->log(1,"editor_upload->funNum",$funcNum);
$util->log(1,"editor_upload->CKEdito",$CKEditor);
$util->log(1,"editor_upload->langCode",$langCode);

if(isset($_FILES['upload']['name']))
{	
	$file_name = $_FILES['upload']['name'];	
	//$file_name = iconv('utf-8', 'euc-kr', $file_name);
	//$file_name = iconv('euc-kr', 'utf-8', $file_name);
	$ext = strtolower(substr($file_name,(strrpos($file_name,'.')+1)));
	
	if('jpg' != $ext && 'jpg' != $ext && 'gif' != $ext && 'png' != $ext)
	{
		echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum,'','이미지만 업로드 가능합니다.');</script>";
		return false;
	}
	
	$org_name = substr($file_name,0,strrpos($file_name,"."));	
	

	$util->log(1,"editor_upload->org_name", $util->chkExistHangul($org_name));
	
	if( $util->chkExistHangul($org_name) ){
		$org_name = "H";
	}
	
	$newfilename = "A".$org_name."_".$util->getGuidText().".".$ext;	
	
	$util->log(1,"file_name->", $newfilename);
	//return;
	
	$save_dir = sprintf('%s/%s', $up_dir, $newfilename);
	$save_url = sprintf('%s/%s', $up_url, $newfilename);

	if(move_uploaded_file($_FILES["upload"]["tmp_name"], $save_dir)){
		echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum,'$save_url','업로드완료');</script>";
		return true;
	}else{
		echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum,'','업로드실패');</script>";
		return false;
	}
}else{
	echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum,'','업로드실패[300]');</script>";
	return false;
}

