<?php
require_once('config/db.php');
require_once('controller/articleController.php');

$db = new Database();
$conn = $db->getConnection();

$article = new Article($conn);

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $image = null;

    if($_FILES['image']['name']){
        $uniqueImage = uniqid()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], './uploads/'. $uniqueImage);
    }
    $article->create($_POST['title'], $_POST['content'], $uniqueImage);
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>Tambah Article</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title Article</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Content Article</label>
                <textarea name="content" class="form-control" id="" ></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control"  >
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>