<?php
	
namespace Blab\Libs;
use Blab\Mvc\Models\BLAB_Model;
use Blab\Libs\Redirect;

class Pagination extends BLAB_Model
{

	protected $tableName='',
			  $displayItems = 3,
			  $where='',
			  $pageLink='',
			  $totalItems=0,
			  $paginationLists ='',
			  $paginationData='',
			  $orderName,
			  $orderType;

	public function __construct($table='',$totalItems='',$pageLink='',$params='',$where="",$displayItems='',$orderName='id',$orderType='DESC'){

			// Call parent __construct to instantiate database

			Parent::__construct();

			//Check Input empty or not

			if (!empty($table)) {
				
				$this->tableName= $table;
			}else{

				throw new Exception("Table Name is Required . Please Give Table Name .");
				
			}

			// Here we set how much row(item) display in one page

			if (!empty($totalItems) && $totalItems > 0) {
				
				$this->totalItems = (int)$totalItems;
			}else{

				throw new Exception("Total Items Number is required .");
				
			}

			if (!empty($displayItems) && $displayItems>0) {
				
				$this->displayItems = (int)$displayItems;
			}

			if (!empty($pageLink)) {
				
				$this->pageLink = $pageLink;
			}

			if(!empty($where)){

				$this->where = $where;
			}

			$this->orderName = $orderName;
			$this->orderType = $orderType;

			// Here we set last page

			$lastPage= (int)ceil($this->totalItems/$this->displayItems); 

			// Make Sure last_page  doesn't less than 1

			if ($lastPage < 1) {
				$lastPage = 1;
			}

			// Get page number from url using GET if page number set , otherwise page number always 1

			if (!isset($params) || $params==null) {
				
				$params= \Blab\Mvc\Bootstrap::getRouter()->getParams();
				if (isset($params[0])) {
					$pageNum=(int)preg_replace('#[^0-9]#', '', $params[0]);
				}else{
					$pageNum = 1 ;
				}

			}else{

				if ($params!='') {
					$pageNum=preg_replace('#[^0-9]#', '', $params);
				}else{
					$pageNum = 1 ;
				}
			}

			// Make Sure the page number isn't less than 1 or more than last_page

			if ($pageNum < 1) {
				$pageNum = 1 ;
			}else if ($pageNum > $lastPage) {
				$pageNum = $lastPage;
				Redirect::to(rtrim($this->pageLink,'/').'/'.$pageNum);
			}

			// Establish the $paginationCtrls variable

			$this->paginationLists = '<ul class="pagination pagination-md">';

			// If there is more than 1 page worth of results

			if($lastPage != 1){

				/* First we check if we are on page one. If we are then we don't need a link to 
				   the previous page or the first page so we do nothing. If we aren't then we
				   generate links to the first page, and to the previous page. */

				if ($pageNum > 1) {
			        $previous = $pageNum - 1;
					$this->paginationLists .= '<li><a href="'.$pageLink.$previous.'">Previous</a></li>';

					// Render clickable number links that should appear on the left of the target page number

					// How many items Show in left from selection page

					$showLeft=5;

					for($i = $pageNum-$showLeft; $i < $pageNum; $i++){
						if($i > 0){
					        $this->paginationLists .= '<li><a href="'.$pageLink.$i.'">'.$i.'</a></li>';
						}
				    }
			    }
				// Render the target page number, but without it being a link
				$this->paginationLists .= '<li class ="active"><a href="#">'.$pageNum.'</a></li> ';
				// Render clickable number links that should appear on the right of the target page number
				for($i = $pageNum+1; $i <= $lastPage; $i++){
					$this->paginationLists .= '<li><a href="'.$pageLink.$i.'">'.$i.'</a></li>';
					if($i >= $pageNum+5){
						break;
					}
				}
				// This does the same as above, only checking if we are on the last page, and then generating the "Next"
			    if ($pageNum != $lastPage) {
			        $next = $pageNum + 1;
			        $this->paginationLists .= '<li><a href="'.$pageLink.$next.'">Next</a></li>';
			        $this->paginationLists.='</ul>';
			    }
			}

			// This set the range of item(row) that we will display per page

			$limit = 'LIMIT ' .($pageNum - 1) * $this->displayItems .',' .$this->displayItems; // LIMIT start_from , how much
			// Set Order

			$ext = "ORDER BY {$this->orderName} {$this->orderType}"." ".$limit;

			$sql = "SELECT * FROM {$this->tableName} {$this->where} {$ext}";

			$this->paginationData = $this->_db->execute($sql)->getResults();

		//Store All The pagination link
	}

	public function getPaginationLists(){

		return $this->paginationLists;
	}

	public function getPaginationData(){

		return $this->paginationData;
	}
}