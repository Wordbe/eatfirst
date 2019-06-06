<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("recipe_no", $_GET)) {
    $recipe_no = $_GET["recipe_no"];
    
    // for recipe
    $query = "select *
    		  from recipe natural join foodtype
    		  where recipe_no = $recipe_no";
    $res = mysqli_query($conn, $query);
    $recipe = mysqli_fetch_assoc($res);
    if (!$recipe) {
        msg("요리법이 존재하지 않습니다.");
    }
    
    // for review
    $review_query = "select * 
    				from recipe natural join review 
    				where recipe_no = $recipe_no";
    $review_res = mysqli_query($conn, $review_query);
}
?>

    <div class="container fullwidth">
        <h3> 맛있는 <b> <?php echo $recipe['recipe_name']; ?></b> 만들어 봅시다! </h3>
        <br>
        
        <p>
            <label for="recipe_no">요리법 번호</label>
            <input readonly type="text" id="recipe_no" name="recipe_name" value="<?= $recipe['recipe_no'] ?>"/>
	        </p>
        
        <p>
            <label for="recipe_name">요리법 이름</label>
            <input readonly type="text" id="recipe_name" name="recipe_name" value="<?= $recipe['recipe_name'] ?>"/>
        </p>
        
        <p>
            <label for="foodtype_name">음식점 분류</label>
            <input readonly type="text" id="foodtype_name" name="foodtype_name" value="<?= $recipe['foodtype_name'] ?>"/>
        </p>
        
        <p>
            <label for="content">요리법 내용</label>
            <textarea readonly id="content" name="content" rows="10"><?= $recipe['content'] ?></textarea>
        </p>

        <p>
            <label for="made_date">등록일자</label>
            <input readonly type="text" id="made_date" name="made_date" value="<?= $recipe['made_date'] ?>"/><br><br>
        </p>
        
    </div>
    
    
<?php include("footer.php") ?>