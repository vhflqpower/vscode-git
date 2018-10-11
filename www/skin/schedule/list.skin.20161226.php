


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



				<? if($board['bo_use_category']){ ?>
				<form class="navbar-form navbar-left" role="search" name="searchForm" method="get" action="./list.php">
				  
				  <? if($board['bo_cate_type']=='selectbox'){ ?>
				  <div class="form-group">
				  <input type="hidden" name="bo_table" value="<?=$bo_table?>">
					<select name="ca_name" class="form-control" style="width:150px" onchange="document.searchForm.submit()">
					<?=get_category_option($bo_table,'--선택--',$ca_name);?>
					</select>		
				  </div>
				
					<? }else{ ?>

					<nav>
					  <ul class="pagination">
					<?
						for($i=0; $i < count($cate_item); $i++){
						$cate=explode(":",$cate_item[$i]);
					?>
						<li <?if($ca_name==$cate[0]){?>class="active" <?} ?>>
						  <a href='./list.php?bo_table=<?=$bo_table?>&ca_name=<?=$cate[0]?>'><?=$cate[1]?><span class='sr-only'>(current)</span></a>
						</li>
					
					<? } ?>
						
					  </ul>
					</nav>				

					<? } ?>
				
				</form>
				<? } ?>

					

			<table class="table table-striped table-bordered" ><!-- table-hover" -->
					 <!--<caption>테이블 설명</caption> -->
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
							<td><?=$row['wr_name']?></td>
							<td><?=$row['wr_datetime']?></td>
							<td><?=$row['wr_hit']?></td>
						</tr>

			 <?
						
					
					$num++;	 } 

					if($num < 1){ echo "<tr><td colspan=5 style='text-align:center'>NO DATA</td></tr>"; }


					$write_pages = get_paging($page_count, $page, $total_page, "./list.php?bo_table=$bo_table".$qstr."&page=");


			 ?>  

						</tr>
					</tbody>
				</table>



		 <!-- <div style="border:0px solid red;width:100%;positon:relative;">
 -->
		 <div style="float:right;height:60px;">

			
			</div>


		<div style="float:left;">
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>글쓰기
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./admin/bbs_list.php'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>관리
			</button>
          </div>

          </div>

		<!-- <div style="float:left;border:0px solid red;width:100%;positon:relative;text-align:center;">
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
			</div>
 -->



<!-- </div> -->
        </div><!--/.col-xs-12.col-sm-9-->

