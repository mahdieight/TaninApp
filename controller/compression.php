<?php
class CompressionController{

	public function createZipFile($saveTopath,$folderToZip,$crc){
		chmod(getcwd() . "/" . $saveTopath, 0755);
		chmod(getcwd() . "/" . $folderToZip, 0755);

		require_once (getcwd(). '/app/Ziper/Zip.php');
		$zip = new Zip();
		$zip->zip_start($saveTopath .'/' .  "$crc-hq.zip");
		$zip->zip_add($folderToZip); // adding a file
		$zip->zip_end();
	}

}