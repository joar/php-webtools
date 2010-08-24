<?php
	class tools {
		public static function preint_r( $data ) {
			foreach ( func_get_args() as $val ) {
				echo '<pre>';
				print_r( $val );
				echo '</pre>';
			}
		}
		public static function dump( $data ) {
			foreach ( func_get_args() as $val ) {
				echo '<pre>';
				var_dump( $val );
				echo '</pre>';
			}
		}
		public static function handle($string) {
			$healthy = array('.', '@', ' ', '�', '�', '�');
			$yummy = array('-', '-', '-', 'a', 'a', 'o');
			$string = strtolower(str_replace($healthy, $yummy, $string));
			$string = preg_replace('/-{1,}/', '-', $string);
			return preg_replace('/[^a-zA-Z0-9\-\/]/', '', $string);		
		}
		function validate_email( $email ) {
			$regex = '#(?:[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])#';
			return preg_match( $regex, $email );
		}
		function json_indent( $json ) {
			$result    = '';
			$pos       = 0;
			$strLen    = strlen( $json );
			$indentStr = "\x20\x20";
			$newLine   = "\n";
			
			for($i = 0; $i <= $strLen; $i++ ) {
				$char = substr( $json, $i, 1 );
				
				if( $char == '}' || $char == ']') {
					$result .= $newLine;
					$pos--;
					for ( $j = 0; $j < $pos; $j++ ) {
						$result .= $indentStr;
					}
				}
				
				$result .= $char;
				
				if ( $char == ',' || $char == '{' || $char == '[') {
					$result .= $newLine;
					if ( $char == '{' || $char == '[') {
						$pos++;
					}
					for ( $j = 0; $j < $pos; $j++ ) {
						$result .= $indentStr;
					}
				}
			}
			$result .= PHP_EOL;
			return $result;
		}
		function fetch_files_from_folder($dir) {
			$files = scandir($dir);
			foreach($files as $key => $file) {
				if($file == '.' || $file == '..')
				{
					unset($files[$key]);
				}
				if(!is_link($dir . $file) && is_dir($dir . $file) && $file != '.' && $file != '..') {
			    	$subfiles = tools::fetch_files_from_folder($dir . $file . '/');
			    	foreach($subfiles as $subfile)
			    	{
			    		array_push($files, $file . '/' . $subfile);
			    	}
			    	unset($files[$key]);
			    }
			}
			return $files;
		}
		
		function time_readable($duration) {
			$days = floor($duration/86400);
			$hrs = floor(($duration - $days * 86400) / 3600);
			$min = floor(($duration - $days * 86400 - $hrs * 3600) / 60);
			$s = $duration - $days * 86400 - $hrs * 3600 - $min * 60;
			
			$return = ($days > 0) ? $days . ' d ' : '';
			$return .= ($days > 0 || $hrs > 0) ? $hrs . ' tim ' : '';
			$return .= ($days > 0 || $hrs > 0 || $min > 0) ? $min . ' min ' : '';
			$return .= ($days > 0 || $hrs > 0 || $min > 0) ? $s . ' s ' : '';

			return $return;
		}
	}