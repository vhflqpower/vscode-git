	<!-- <script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
	<script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shBrushJScript.js"></script>
	<link type="text/css" rel="stylesheet" href="syntaxhighlighter_3.0.83/styles/shCoreDefault.css"/>
	<script type="text/javascript">SyntaxHighlighter.all();</script>
 -->
<?
// [code:xxx] ..... [/code] 변환
function conv_syntaxhighlighter($contents)
{
    if(!$contents)
        return;

    // code 내에 포함된 tag 제거
    preg_match_all('/\[code:[^\]]*\]([^\[]*)\[\/code\]/i', $contents, $matchs);

    for($i=0; $i<count($matchs[0]); $i++) {
        $code = $matchs[0][$i];
        $code = preg_replace('/<[^>]*>[^<]*<\/[^>]*>/', '', $code);
        $code = preg_replace('/<[^\/>]*\/?>/', '', $code);

        $contents = str_replace($matchs[0][$i], $code, $contents);
    }

    // br 태그 제거
    $contents = preg_replace("/<br\s?\/>/i", "", $contents);

    $contents = preg_replace("/\[code:\s*([^\]]+)\]/i", "<pre class=\"brush:\\1\">", $contents);
    $contents = preg_replace("/\[\/code\]/i", "</pre>", $contents);

    return $contents;
}


$content = $view['contents'];
  // $content = conv_syntaxhighlighter($view['contents']);
?>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/styles/shCore<?=$board['bo_syntax_type']?>.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shCore.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushAS3.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushAppleScript.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushBash.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushCSharp.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushColdFusion.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushCpp.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushCss.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushDelphi.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushDiff.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushErlang.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushGroovy.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushJScript.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushJava.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushJavaFX.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPhp.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPlain.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPowerShell.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPython.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushRuby.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushSass.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushScala.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushSql.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushVb.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushXml.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shAutoloader.min.js"></script>
	<script type="text/javascript">SyntaxHighlighter.all();</script>

<!-- 
	<link type="text/css" rel="stylesheet" href="syntaxhighlighter_3.0.83/styles/shThemeMidnight.css"/>
	<script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
	<script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shBrushJScript.js"></script>
	<script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shBrushPhp.js"></script>
	<script type="text/javascript">SyntaxHighlighter.all();</script>

 -->
	<div class="page-header">
            <h3><!-- <?=$board['bo_subject']?> --><?=$view['wr_subject']?></h3>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">



        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


          <!-- <h3 class="sub-header">Section title</h3> -->
           <div class="table-responsive">

				<table class="table table-striped table-bordered "><!-- table-hover -->
				<!-- <caption><h3><?=$view['wr_subject']?></h3></caption> -->
				<!-- <thead>
					<tr>
						<th>NO</th>
						<th>제목</th>

					</tr>
				</thead> -->
				<tbody>

					<tr>
						<td><span>DATE:<span style='color:#0000ff;'><?=$view['wr_datetime']?></span></span> <span style="float:right;">HIT:<?=$view['wr_hit']?></span></td>

					</tr>
					<tr>
					
						<td>
						<div style="min-height:250px;"><?=$content?></div>
						</td>

					</tr>      

				</tbody>
			</table>
		<? if($view['wr_source']){ ?>
			<pre class="brush:php;"><?=$view['wr_source']?></pre>
		<? } ?>


<div style="float:right">
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
<? if($member['mb_id']=='psj007'){ ?>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&oper=edit'">
			  <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>수 정
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="del()">
			  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>글쓰기
			</button>
<? } ?>
</div>


          </div>

        </div><!--/.col-xs-12.col-sm-9-->

			<form name="fdel" method="post" action="./write_update.php">
			<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
			<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
			<input type="hidden" name="oper" value="del" />
			</form>



	 <script>
	 function del()
	{
		if (confirm('한번 삭제한 자료는 복구가 되지 않습니다. 정말로 삭제하시겠습니까?'))
		{

			document.fdel.submit();
			//$('#fdel').submit();
		}
	}
			
	 </script>
