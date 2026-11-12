<?php

include("connectsms.php");
  $resultArray = array();
  $standard = $_REQUEST['standard'];
  $subject = $_REQUEST['subject'];
  $book_val = $_REQUEST['book'];
  $book_exp = explode(' - ', $book_val);
  $book = $book_exp[0];
  $author = $book_exp[1];


  $book_sql=mysql_query("SELECT * from mst_syllabus where syllabus_std_id='$standard' and syllabus_subject_id='$subject' and syllabus_id='$book'");
  if(mysql_num_rows($book_sql) > 0){
  while($book_row=mysql_fetch_array($book_sql)){
              $std_id=$book_row['syllabus_std_id']; 
              $sub_id=$book_row['syllabus_subject_id']; 
              $book_name=$book_row['syllabus_bookname'].' - '.$book_row['syllabus_subject_author']; 

                            
                $unit_sql=mysql_query("SELECT group_concat(syllabus_subject_chapter) chapter,syllabus_std_id,syllabus_subject_id,syllabus_subject_book,syllabus_subject_unit from tbl_syllabus_unitchapter_details where syllabus_subject_id='$sub_id' and syllabus_std_id='$std_id' and syllabus_subject_book='$book_name' and syllabus_subject_chapter!='' group by syllabus_subject_unit order by syllabus_id asc");
                while($unit_row=mysql_fetch_array($unit_sql)){
                  $chapter_std=$unit_row['syllabus_std_id']; 
                  $chapter_sub=$unit_row['syllabus_subject_id']; 
                  $chapter_unit=$unit_row['chapter']; 
                  $chapter_book=$unit_row['syllabus_subject_book']; 
                  $unit=$unit_row['syllabus_subject_unit'];
                  //$array[]=$unit;
                        $exp_chap=explode(',', $chapter_unit);
                        if(count($exp_chap)>1){
                        for ($i=0; $i < count($exp_chap); $i++) { 
                          $imp_chap[]='\''.$exp_chap[$i].'\'';
                        }
                          $chapter=implode(',', $imp_chap);
                        } elseif(count($exp_chap)==1) {
                          $chapter='\''.$chapter_unit.'\'';
                        }
                  
                  $chapter_sql="SELECT syllabus_id,syllabus_subject_unit,syllabus_subject_chapter from tbl_syllabus_unitchapter_details where syllabus_subject_chapter IN ($chapter) and syllabus_subject_book='$chapter_book' and syllabus_subject_unit='$unit' and syllabus_std_id='$chapter_std' and syllabus_subject_chapter!='' and syllabus_subject_id='$chapter_sub'";
                        	$objQuery = mysql_query($chapter_sql);
				$intNumField = mysql_num_fields($objQuery);
				while($obResult = mysql_fetch_array($objQuery))
				{
					$arrCol = array();
					for($i=0;$i<$intNumField;$i++)
					{
						$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
						
					}
					array_push($resultArray,$arrCol);
				}
}
}
                          echo json_encode($resultArray);
}
?>