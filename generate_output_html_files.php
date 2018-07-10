<?php
/*
 * PHP to HTML Static Compiler
 * @author Matthew Paul Gross (http://github.com/mpge)
 *
 * The MIT License (MIT)
 * 
 * Copyright (c) 2007-2013 Einar Lielmanis and contributors.
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge,
 * publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE. 
 */

	// Settings
	$fileDir = '/../';
	$fileExtensions = 'php'; // Seperate by comma. Can support multiple extensions.
	$newExtension = 'html';
	$compiledDestination = '/../compiled_html/';
	$shouldBeautify = true;
	$shouldFixUTFQuotes = true;
	// End Settings
	
	$rootPath = realpath(dirname(__FILE__));
	
	// Require beautify script.
	require_once($rootPath . '/vendor/beautify-html/beautify-html.php');
	
	// Set the beautify options
	$beautify = false;
	if($shouldBeautify = true) {
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
	}
	
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
			$outputLog = "Saving " . $file . " to " . $compiledDestination . $newFileName . "\n";
			
			if($shouldBeautify == true && $beautify != false) {
				$outputLog = 'Beautifying & ' . $outputLog;
				
				$htmlOutput = $beautify->beautify($htmlOutput);
			}
			
			if($shouldFixUTFQuotes == true) {
				// add the function
				function convert_smart_quotes($string) {
					$search = array(chr(0xe2) . chr(0x80) . chr(0x98),
							chr(0xe2) . chr(0x80) . chr(0x99),
							chr(0xe2) . chr(0x80) . chr(0x9c),
							chr(0xe2) . chr(0x80) . chr(0x9d),
							chr(0xe2) . chr(0x80) . chr(0x93),
							chr(0xe2) . chr(0x80) . chr(0x94),
							chr(226) . chr(128) . chr(153),
							'â€™','â€œ','â€<9d>','â€"','Â  ');

					 $replace = array("'","'",'"','"',' - ',' - ',"'","'",'"','"',' - ',' ');

					return str_replace($search, $replace, $string);
				}
				
				// and run it.
				$htmlOutput = convert_smart_quotes($htmlOutput);
			}
			
			file_put_contents($rootPath . $compiledDestination . $newFileName, $htmlOutput);
		}
	}
?>
