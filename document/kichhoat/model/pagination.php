<?php
class pagination{
	
	protected $page;
	protected $totalRows;
	protected $rowsPerpage;
	protected $perRow;
	protected $totalPages;

	protected $listPages;
	
	

	
	// Phương thức tính tổng số mẩu tin
	function totalRows($tableName){
		
		$sql = "SELECT * FROM ".$tableName;
		$result=@mysqli_query($sql);
		$this->totalRows = mysqli_num_rows($result);
	}
	
	// Phương thức tính tổng số trang
	function totalPages($rowsPerPage){
		
		$this->totalPages = ceil($this->totalRows/$rowsPerPage);
	}
	
	//Phương thức lấy trang hiện tại
	function page(){
		
		if(isset($_GET['page'])){
			$this->page = $_GET['page'];
		}
		else{
			$this->page = 1;	
		}
		return $this->page;
	}
	
	// Phương thức tính vị trí mẩu tin đầu tiên trên mỗi trang
	function perRow($page, $rowsPerPage){
					
		$this->perRow = $page*$rowsPerPage - $rowsPerPage;
		return $this->perRow;
	}
	
	// Phương thức phân trang
	function listPages(){
		
		$this->listPages = '';
		for($i=1; $i<=$this->totalPages; $i++){
			
			if($this->page == $i){
				
				$this->listPages .= '<span>'.$i.'</span> ';
			}
			else{
				$this->listPages .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> ';
			}
		}
		return $this->listPages;
	}
	
	
	
	
	
	
	
	
	
	
	
}

?>