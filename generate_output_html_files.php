<?php
	// Settings
	$fileDir = '/../';
	$fileExtensions = 'php'; // Seperate by comma.
	$newExtension = 'html';
	$compiledDestination = '/../compiled_html/';
	
	$rootPath = realpath(dirname(__FILE__));
	
	// Require beautify script.
	require_once($rootPath . '/vendor/beautify-html/beautify-html.php');
	
	// Set the beautify options
	$beautify = new Beautify_Html(array(
	  'indent_inner_html' => false,
	  'indent_char' => " ",
	  'indent_size' => 4,
	  'wrap_line_length' => 32786,
	  'unformatted' => ['code', 'pre'],
	  'preserve_newlines' => false,
	  'max_preserve_newlines' => 32786,
	  'indent_scripts'	=> 'normal' // keep|separate|normal
	));
	
	// Loop through the directory finding all files with that extension.
	$files = glob($rootPath . $fileDir . '*.{' . $fileExtensions . '}', GLOB_BRACE);
	
	// Loop through each file, using output buffer to generate html, and save the file in the compiledDestination.
	foreach($files as $file) {
		ob_start();
		require $file;
		$htmlOutput = ob_get_clean();
		
		// Get the file name.
		$allFileExtensions = explode(',', $fileExtensions);
		
		$newFileName = false;
		
		foreach($allFileExtensions as $fileExtension) {
			// Check to see if the file has this extension.
			if(strpos($file, $fileExtension) !== false)	{
				// It does, set the newFileName to this (replacing the extension with $newExtension)
				$newFileName = str_replace($fileExtension, $newExtension, basename($file));
			}
		}
		
		if($newFileName != false) {
			print "Beautifying & Saving " . $file . " to " . $compiledDestination . $newFileName . "\n";
			
			$beautifiedHtmlOutput = $beautify->beautify($htmlOutput);
			
			file_put_contents($rootPath . $compiledDestination . $newFileName, $htmlOutput);
		}
	}
?>