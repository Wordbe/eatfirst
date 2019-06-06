<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("review_no", $_GET)) {
    $review_no = $_GET["review_no"];
    $query = "select *
    		  from review
    		  where review_no = $review_no";
    $res = mysqli_query($conn, $query);
    $review = mysqli_fetch_assoc($res);
    if (!$review) {
        msg("리뷰가 존재하지 않습니다.");
    }
}
?>

    <div class="container fullwidth">
		
        <h3> <b>리뷰명: <?php echo $review['title']; ?></b> </h3>
        <br>
        
        <p>
            <label for="review_no">리뷰 번호</label>
            <input readonly type="text" id="review_no" name="review_no" value="<?= $review['review_no'] ?>"/>
	    </p>
        
        <p>
            <label for="title">리뷰 제목</label>
            <input readonly type="text" id="title" name="title" value="<?= $review['title'] ?>"/>
        </p>
        
        <p>
            <label for="rating">평점</label>
            <input readonly type="text" id="rating" name="rating" value="<?= $review['rating'] ?>"/>
        </p>
        
        <p>
            <label for="content">내용</label>
            <input readonly type="text" id="content" name="content" value="<?= $review['content'] ?>"/>
        </p>

        <p>
            <label for="reviewed_date">등록일자</label>
            <input readonly type="text" id="reviewed_date" name="reviewed_date" value="<?= $review['reviewed_date'] ?>"/>
        </p>
    </div>
    
<?php include("footer.php") ?>