<?
include_once('./_common.php');


$stx = $_GET['stx'];
$sql = "select
			subject
		from
			psj_issu_log
		where
			subject like '%".$stx."%'
 ";

/*
		group by
			subject
		order by
			subject asc
*/

$result = sql_query($sql,true);

// value : 검색된 단어이며, input 값으로 넘어갑니다.
// label : 특정검색어를 입력시 자동완성 리스트로 표시됩니다. (다양하게 응용가능)
while($row=sql_fetch_array($result)) {
	$arr[] = array(
				"value"	=> $row['subject'],
				"label"	=> $row['subject']
				);
}
echo json_encode($arr);

?>