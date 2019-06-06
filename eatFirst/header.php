<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>Eat First</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<form action="restaurant_list.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">Eat First</a>
            <ul class='pull-right'>
                <li>
                    <input type="text" name="search_keyword" placeholder="음식점 or 분류 검색">
                </li>
                <li><a href="restaurant_list.php">음식점</a></li>
                <li><a href='review_list.php'>reviews</a></li>
                <li><a href='recipe_list.php'>요리법</a></li>
                <li><a href='board_list.php'>게시판</a></li>
                <li><a href='site_info.php'>about</a></li>
            </ul>
        </div>
    </div>
</form>

    