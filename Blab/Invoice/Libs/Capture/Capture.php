<?php

namespace Blab\Invoice\Libs\Capture;

use Blab\Invoice\Libs\Views\View;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\Response;

class Capture
{
	protected $view;

	protected $pdf;

	protected $uniqID;

	protected $captureFileName;

	protected $capturePath = 'http://localhost/Invoice/invoice';

	protected $rootPath = 'http://localhost';

	protected $viewPath = 'views';

	protected $path;

	protected $tempPath;

	protected $envPath;

	protected $captureJS = "/";

	protected $tempDir = 'storage/';

	public function __construct(array $paths=[]){

		foreach ($paths as $key => $value) {
			$this->{$key} = rtrim($value,DS);
		}

		$this->view = new View($this->viewPath);

		if (!isset($this->envPath)) {
			putenv('PATH='.ROOT.DS.'Blab'.DS.'Invoice'.DS.'bin');
		}else{
			putenv('PATH='.$this->envPath);
		}

	}

	public function load($filename, array $data = []){

		$view = $this->view->render($filename,$data);

		$this->captureFile($view);
	}

	/*
	 * Same work look like response
	*/

	public function download($filename){
		$path = $this->pdf;

		header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
		// header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
		header('Accept-Ranges: bytes');  // For download resume
		header('Content-Length: ' . filesize($path));  // File size
		header('Content-Encoding: none');
		header('Content-Type: application/pdf');  // Change this mime type if the file is not PDF
		header('Content-Disposition: attachment; filename=' . $filename);  // Make the browser display the Save As dialog
		readfile($path);  //this is necessary in order to get it to actually download the file, otherwise it will be 0Kb
	}

	public function response($filename=null){
		if (!null == $filename) {
			$name = $filename;
		}else{
			$name = basename($this->pdf);
		}
		// Generate response
		$response = new Response(file_get_contents($this->pdf),200,[

				'Content-Type' => 'application/pdf',
            	'Content-Description' => 'File Transfer',
            	'Content-Disposition' => 'attachment; filename="' . $name . '.pdf"',
            	'Content-Transfer-Encoding' => 'binary',
            	'Content-Length'=>filesize($this->pdf)

			]);

		// Set headers
		// $response->headers->set('Cache-Control', 'private');
		// $response->headers->set('Content-type', mime_content_type($this->pdf));
		// $response->headers->set('Content-Disposition', 'attachment; filename="' . $name . '";');
		// $response->headers->set('Content-length', filesize($this->pdf));

		// Send headers before outputting anything
		// $response->sendHeaders();

		// $response->setContent(file_get_contents($this->pdf));

		unlink($this->pdf);
		unlink($this->tempPath);

		$response->send();
	}

	protected function captureFile($view){
		$this->path = $this->putContent($view);
		$this->phantomProcess($this->path)->setTimeout(10)->mustRun();
	}

	protected function putContent($view){

		if (isset($this->captureFileName)) {
			$this->uniqID = $this->captureFileName;
		}else{

			$this->uniqID = md5(uniqid());
		}

		if (!is_dir($this->tempDir)) {
			mkdir($this->tempDir);
		}

		file_put_contents($this->tempPath = $this->tempDir.'/'.$this->uniqID.'.php',$view);

		return $this->tempPath;
	}

	protected function phantomProcess($path){

		$this->pdf = $this->tempDir.'/'.$this->uniqID.'.pdf';

		$url =$this->capturePath.'/'.$this->uniqID.'.php';

		// You can use exec('phantomjs '.$this->captureJS.' '.$url.' '.$this->pdf); if you do not want symfony Process
		return new Process('phantomjs '.$this->captureJS.' '.$url.' '.$this->pdf); 
	}
}