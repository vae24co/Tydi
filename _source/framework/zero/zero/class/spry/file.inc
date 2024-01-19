<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* FileX ~ File Utility • VERSION » alpha-0.0.1 ***/

class FileX {

	public static function is($path, $type='FILE'){
		if($type === 'FILE'){
			if(is_file($path) && file_exists($path) && !is_dir($path)){return true;}
		}
		elseif($type === 'DIR'){
			if(is_dir($path) === true){return true;}
		}
		elseif($type === 'WRITE'){
			return is_writable($path);
		}
		return false;
	}


	public static function size($file, $unit='AUTO'){
		$byte = filesize($file);
		return FormatX::toUnit($byte, $unit);
	}


	public static function isType($data, $document=''){
		if(is_array($data)){
			if(!empty($data['type'])){$mime = $data['type'];}
			elseif(!empty($data['mime'])){$mime = $data['mime'];}
		}
		else {
			$mime = $data;
		}

		#image
		if($mime === 'image/jpeg'){$o = ['extension' => '.jpg', 'document' => 'PHOTO', 'kind' => 'JPEG'];}
		if($mime === 'image/png'){$o = ['extension' => '.png', 'document' => 'PHOTO', 'kind' => 'PNG'];}
		if($mime === 'image/gif'){$o = ['extension' => '.gif', 'document' => 'PHOTO', 'kind' => 'GIF'];}

		#video
		if($mime === 'video/x-matroska'){$o = ['extension' => '.mkv', 'document' => 'VIDEO', 'kind' => 'MKV'];}


		if(!empty($o)){
			if(!StringX::empty($document)){
				if($o['document'] === $document){return true;}
				return false;
			}
			return $o;
		}
		return false;
	}



	//TODO:
	#In • RETURNS required -file when its valid & exist
	public static function inc($path, $required=true, $once=true){
		if($required === true){
			self::is($path);
			if($once === true){
				require_once $path;
			} else {
				require $path;
			}
		}
		else {
			if(self::is($path, 'iFILE') !== false){
				if($once === true){
					require_once $path;
				} else {
					require $path;
				}
			}
		}
	}


















	#INFO • returns file information
	public static function info($res='iDATA', $file='iSELF'){
		if($file == 'iSELF'){$file = $_SERVER['PHP_SELF'];}
		$path = pathinfo($file);
		if($res == 'iDIR' && !empty($path['dirname'])){$o = $path['dirname'];}
		elseif($res == 'iBASE' && !empty($path['basename'])){$o = $path['basename'];}
		elseif($res == 'iEXT' && !empty($path['extension'])){$o = $path['extension'];}
		elseif($res == 'iNAME' && !empty($path['filename'])){$o = $path['filename'];}
		elseif($res == 'iDATA'){$o = $path;}
		if(!empty($o)){return $o;}
		return false;
	}



	#DOWNLOAD • force file download
	public static function download($file, $save=''){
		if(self::is($file, 'iFILE')){
			$name = self::info('iNAME', $file);
			$ext = self::info('iEXT', $file);
			if(!empty($save)){$save = time().mt_rand();}
			$save = $save.'.'.$ext;
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename ="'.$save.'"');
			readfile($file);
			exit;
		}
	}



	#@TODO ~ Test & code file UPLOAD
	public static function upload($field='upload', $config='', $return = ''){
		$file = $field;
		if(!empty($config['fileDir'])){$fileDir = $config['fileDir'];} else {$fileDir = "odrive/";}
		if(!empty($config['fileName'])){$fileName = $config['fileName'];} else {$fileName = mt_rand().'_'.basename($file["name"]);}
		#if(!empty($config['filesAllowed'])){$filesAllowed = $config['filesAllowed'];} else {$filesAllowed = array('jpg','png','jpeg','gif','pdf', 'md');}

		$fileTemp = $file["tmp_name"];
		$filePath = $fileDir.$fileName;
		$fileType = pathinfo($fileTemp);
		$rez = array();

		if($file['error'] < 1){
			# if(in_array($fileType, $filesAllowed)){
					#check if a file exists on the destination
			if(self::is($filePath)){$rez['error'] = array('message' => 'File name already exists');}
			else {
				$uploadFile = move_uploaded_file($fileTemp, $filePath);
				if($uploadFile === true){$rez['fileName'] = $fileName;}
			}
			# }
			# else {
			# 	$rez['error'] = array('message' => 'File type not allowed', 'type_uploaded' => $fileType);
			# }
		}
		else {
			$rez['error'] = $file['error'];
		}
		return $rez;
	}



	public static function compress_image($source, $destination, $quality=80){
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source);
		elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source);
		imagejpeg($image, $destination, $quality);
		# echo "Image uploaded successfully.";
	}




} /*** End Of ~FileX ***/