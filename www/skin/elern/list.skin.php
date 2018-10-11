


	<div class="page-header">
            <h3><?=$board['bo_subject']?></h3>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>

          <!-- <h3 class="sub-header">Section title</h3> -->
           <div class="table-responsive">

			<table class="table table-striped table-bordered" ><!-- table-hover" -->
					 <!--<caption>테이블 설명</caption> -->
					 <col width="5%">
					 <col width="50%">
					 <col width="10%">
					 <col width="10%">
					 <col width="5%">
					<thead>
						<tr style="background-color:#ccc;color:#000">
							<th>NO</th>
							<th>제목</th>
							<th>작성자</th>
							<th>작성일</th>
							<th>조회</th>
						</tr>
					</thead>
					<tbody>

	
					<? 
					for ($i=0; $i<count($list); $i++) { 
						$bg = $i%2 ? 0 : 1;
					?>
							<tr>
							<td><div align='center'><!-- <?=$list[$i][num]?> -->
							            <? 
										if ($list[$i][is_notice]) // 공지사항 
											echo "<b>공지</b>";
										else if ($wr_id == $list[$i][wr_id]) // 현재위치
											echo "<span class='current'>{$list[$i][num]}</span>";
										else
											echo $list[$i][num];
										?>
							</div></td>
							<td><a href="./view.php?bo_table=<?=$bo_table?>&wr_id=<?=$list[$i][wr_id]?>"><?=$list[$i][subject]?></a></td>
							<td><?=$list[$i][name]?></td>
							<td><?=$list[$i][datetime2]?></td>
							<td><?=$list[$i][wr_hit]?></td>
						</tr>

			 <?
											
					$num++;	 } 

					if($num < 1){ echo "<tr><td colspan=5 style='text-align:center'>NO DATA</td></tr>"; }


					$write_pages = get_paging($page_count, $page, $total_page, "./list.php?bo_table=$bo_table".$qstr."&page=");


			 ?>  

						</tr>
					</tbody>
				</table>

		<!-- <div style="border:1px solid red;width:100%;positon:relative;">

			<form name="form1" method="get">
			<input type="hidden" name="bo_table" value="<?=$bo_table?>">
			<input type="hidden" name="sca"      value="<?=$sca?>">
				<select name="sf" class="form-control" style="width:150px">
				<option value="wr_subject">제목</option>
				<option value="wr_content">내용</option>
				</select>
				<input  name="stx"  maxlength="15" itemname="검색어" required value='<?=stripslashes($stx)?>' style="width:200px;" class="form-control" />
			<button type="submit" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>조회하기
			</button>
			</form>
		</div> -->

		 <div style="border:0px solid red;width:100%;positon:relative;">

		<div style="float:right;height:60px;">
			 <ul class="pagination"> 
			<? if ($prev_part_href) { echo "<li><a href='$prev_part_href'>이전검색</a></li>"; } ?> 
			<? 
			// 기본으로 넘어오는 페이지를 아래와 같이 변환하여 다양하게 출력할 수 있습니다. 
			$write_pages = str_replace("이전", "<span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>", $write_pages); 
			$write_pages = str_replace("다음", "<span class='glyphicon glyphicon-triangle-right' aria-hidden='true'></span>", $write_pages); 
			$write_pages = str_replace("처음", "<span class='glyphicon glyphicon-backward' aria-hidden='true'></span>", $write_pages); 
			$write_pages = str_replace("맨끝", "<span class='glyphicon glyphicon glyphicon-forward' aria-hidden='true'></span>", $write_pages); 
			?> 
			<?=$write_pages?> 
			<? if ($next_part_href) { echo "<li><a href='$next_part_href'>이후검색</a></li>"; } ?> 
			</ul>
			
			</div>


		<div style="float:left;">
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>글쓰기
			</button>
          </div>

          </div>

		<div style="float:left;border:0px solid red;width:100%;positon:relative;text-align:center;">
					<form class="navbar-form navbar-left" role="search"  method="get">
			<input type="hidden" name="bo_table" value="<?=$bo_table?>">
			<input type="hidden" name="sca"      value="<?=$sca?>">
					  <div class="form-group">
					<input type="hidden" name="bo_table" value="<?=$bo_table?>">
								<input type="hidden" name="sca"   value="<?=$sca?>">
									<select name="sf" class="form-control" style="width:150px">
									<option value="wr_subject">제목</option>
									<option value="wr_content">내용</option>
									</select>
						<input type="text"  name="stx"  maxlength="15" itemname="검색어" required value='<?=stripslashes($stx)?>' class="form-control" placeholder="Search">
					  </div>
					  <button type="submit" class="btn btn-default">검 색</button>
					</form>

				<? if($board['bo_use_category']){ ?>
				<form class="navbar-form navbar-left" role="search" name="searchForm" method="get" action="./list.php">
				  <div class="form-group">
				  <input type="hidden" name="bo_table" value="<?=$bo_table?>">
				<select name="ca_name" class="form-control" style="width:150px" onchange="document.searchForm.submit()">
				<option value=''>선택하세요</option>
				<?=get_category_option($bo_table,$ca_name);?>
				</select>
				  </div>
				</form>
				<? } ?>


			</div>






</div>
        </div><!--/.col-xs-12.col-sm-9-->

