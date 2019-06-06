<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "recipe_insert.php";

if (array_key_exists("recipe_no", $_GET)) {
    $recipe_no = $_GET["recipe_no"];
    $query =  "select *
    		   from recipe natural join foodtype
    		   where recipe_no = $recipe_no";
    $res = mysqli_query($conn, $query);
    $recipe = mysqli_fetch_array($res);
    
    if(!$recipe) {
        msg("요리법이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "recipe_modify.php";
}

$foodtypes = array();

$query = "select * 
		  from foodtype";
		  
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $foodtypes[$row['foodtype_no']] = $row['foodtype_name'];
}
?>

    <div class="container">
        <form name="recipe_form" action="<?=$action?>" method="post" class="fullwidth">
        	
            <h3>요리법 정보 <?=$mode?></h3>
            <br/>
            <p>
	            <input type="hidden" placeholder="요리법 번호 입력" id="recipe_no" name="recipe_no" value="<?= $recipe['recipe_no'] ?>"/>
	        </p>
            
            <p>
                <label for="recipe_name">요리법 이름</label>
                <input type="text" placeholder="요리법 이름 입력" id="recipe_name" name="recipe_name" value="<?=$recipe['recipe_name']?>"/>
            </p>
            
	        <p>
                <label for="foodtype_no">음식 분류</label>
                <select name="foodtype_no" id="foodtype_no">
                    <option value="-1">선택</option>
                    <?php
                        foreach($foodtypes as $number => $name) {
                            if($number == $restaurant['foodtype_no']){
                                echo "<option value='{$number}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$number}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            
	        <p>
	            <label for="content">요리법 내용</label>
	            <textarea placeholder="요리법 내용 입력" id="content" name="content" rows="10"><?= $recipe['content'] ?></textarea>
	        </p>
            

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("recipe_name").value == "") {
                        alert ("요리법 이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("foodtype_no").value == "-1") {
                        alert ("음식점 분류를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("content").value == "") {
                        alert ("내용을 입력해 주십시오"); return false;
                    return true;
                }
            </script>

        </form>
    </div>
    
<?php include("footer.php") ?>