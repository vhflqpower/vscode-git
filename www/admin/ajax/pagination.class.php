<?php
class PerPage {
	public $perpage;
	
	function __construct() {
		$this->perpage = 1;
		$this->perpage2 = 1;
		$this->perpage3 = 1;
	}
	
	function perpage($count,$href) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
	
		if($pages>1) {

     	$output = $output .="<ul class=pagination>";
			$output = $output ."<li ><a class='link' onclick=\"getresult('".$href."1')\"  >처음</a></li>";
			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
					if($i<1) continue;
					if($i>$pages) break;
					if($_GET["page"] == $i){
					 //	$output = $output . '<span id='.$i.' class="current">'.$i.'</span>';
					  $output = $output ."<li class=active><a >$i</a></li>";
					//$output = $output ."<li class=active><a href=./board_list.php?page=$i >$i</a></li>";
					}else{				
					$output = $output ."<li ><a class='link' onclick=\"getresult('$href$i')\" id=pageNo$i>$i</a></li>";
					}
					//	$output = $output . '<a class="link" onclick="getresult(\'' . $href . $i . '\')" >'.$i.'</a>';
				}
			$output = $output ."<li ><a class='link' onclick=\"getresult('".$href.$pages."')\" >끝</a></li>";
			$output = $output .="</ul>";

		}
		return $output;
	}



	function perpage2($count,$href) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage2 != 0)
			$pages  = ceil($count/$this->perpage2);
	
		if($pages>1) {

     	$output = $output .="<ul class=pagination>";
			$output = $output ."<li ><a class='link' onclick=\"getresult2('".$href."1')\"  >처음</a></li>";
			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
					if($i<1) continue;
					if($i>$pages) break;
					if($_GET["page"] == $i){
					 //	$output = $output . '<span id='.$i.' class="current">'.$i.'</span>';
					  $output = $output ."<li class=active><a>$i</a></li>";
					//$output = $output ."<li class=active><a href=./board_list.php?page=$i >$i</a></li>";
					}else{				
						$output = $output ."<li ><a class='link' onclick=\"getresult2('$href$i')\" id=pageNo$i>$i</a></li>";
					}
					//	$output = $output . '<a class="link" onclick="getresult(\'' . $href . $i . '\')" >'.$i.'</a>';
				}
			$output = $output ."<li ><a class='link' onclick=\"getresult2('".$href.$pages."')\" >끝</a></li>";
			$output = $output .="</ul>";

		}
		return $output;
	}


	function perpage3($count,$href) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage3 != 0)
			$pages  = ceil($count/$this->perpage3);
	
		if($pages>1) {

     	$output = $output .="<ul class=pagination>";
			$output = $output ."<li ><a class='link' onclick=\"getresult3('".$href."1')\"  >처음</a></li>";
			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
					if($i<1) continue;
					if($i>$pages) break;
					if($_GET["page"] == $i){
					 //	$output = $output . '<span id='.$i.' class="current">'.$i.'</span>';
					  $output = $output ."<li class=active><a>$i</a></li>";
					//$output = $output ."<li class=active><a href=./board_list.php?page=$i >$i</a></li>";
					}else{				
						$output = $output ."<li ><a class='link' onclick=\"getresult3('$href$i')\" id=pageNo$i>$i</a></li>";
					}
					//	$output = $output . '<a class="link" onclick="getresult(\'' . $href . $i . '\')" >'.$i.'</a>';
				}
			$output = $output ."<li ><a class='link' onclick=\"getresult3('".$href.$pages."')\" >끝</a></li>";
			$output = $output .="</ul>";

		}
		return $output;
	}

}
?>