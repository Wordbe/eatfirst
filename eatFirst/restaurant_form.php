<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "restaurant_insert.php";

if (array_key_exists("restaurant_no", $_GET)) {
    $restaurant_no = $_GET["restaurant_no"];
    $query =  "select *
    		   from restaurant natural join foodtype
    		   where restaurant_no = $restaurant_no";
    $res = mysqli_query($conn, $query);
    $restaurant = mysqli_fetch_array($res);
    
    if(!$restaurant) {
        msg("물품이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "restaurant_modify.php";
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
        <form name="restaurant_form" action="<?=$action?>" method="post" class="fullwidth">
        	
            <h3>음식점 정보 <?=$mode?></h3>
            <br/>
            <p>
	            <!--<label for="restaurant_no">음식점 번호</label>-->
	            <input type="hidden" placeholder="음식점 번호 입력" id="restaurant_no" name="restaurant_no" value="<?= $restaurant['restaurant_no'] ?>"/>
	        </p>
            
            <p>
                <label for="restaurant_name">음식점 이름</label>
                <input type="text" placeholder="음식점 이름 입력" id="restaurant_name" name="restaurant_name" value="<?=$restaurant['restaurant_name']?>"/>
            </p>
	        
	        <p>
                <label for="foodtype_no">음식점 분류</label>
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
	            <label for="address">주소</label>
	            <input type="text" placeholder="주소 입력" id="address" name="address" value="<?= $restaurant['address'] ?>"/>
	        </p>
	
	        <p>
	            <label for="menu">메뉴</label>
	            <input type="text" placeholder="메뉴 입력" id="menu" name="menu" value="<?= $restaurant['menu'] ?>"/>
	        </p>
	        
	        <p>
	            <label for="description">음식점 소개</label>
	            <textarea placeholder="음식점 소개 입력" id="description" name="description" rows="10"><?= $restaurant['description'] ?></textarea>
	        </p>
			
	        <p>
	            <label for="delivery">배달가능 여부</label><br>
	            <?php
	              if($restaurant['delivery'] == 'yes'){ ?>
	            	<input type="radio" id="delivery" name="delivery" value="<?=$restaurant['delivery']?>" checked> Yes
	            	<input type="radio" id="delivery" name="delivery" value="no"> No <br>
	            <?php
	            } else if ($restaurant['delivery'] == 'no'){ ?>
	            	<input type="radio" id="delivery" name="delivery" value="yes"> Yes 
	            	<input type="radio" id="delivery" name="delivery" value="<?=$restaurant['delivery']?>" checked> No <br>
	            <?php
	            } else { ?>
	            	<input type="radio" id="delivery" name="delivery" value="yes" checked> Yes 
	            	<input type="radio" id="delivery" name="delivery" value="no"> No <br>
	            <?php
	            }
	            ?>
	            
	        </p>
            
            
            

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    // if(document.getElementById("restaurant_no").value == "") {
                    //     alert ("음식점 번호를 입력해 주십시오"); return false;
                    // }
                    if(document.getElementById("restaurant_name").value == "") {
                        alert ("음식점 이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("foodtype_no").value == "-1") {
                        alert ("음식점 분류를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("address").value == "") {
                        alert ("주소를 입력해 주십시오"); return false;
                    
                    else if(document.getElementById("menu").value == "") {
                        alert ("메뉴를 입력해 주십시오"); return false;
                    else if(document.getElementById("description").value == "") {
                        alert ("음식점 소개를 입력해 주십시오"); return false;
                    
                    else if(document.getElementById("delivery").value == "") {
                        alert ("배달가능 여부를 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
    
<?php include("footer.php") ?>