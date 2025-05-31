<?php
require_once('config/db.php');
require_once('controller/articleController.php');

$db = new Database();
$conn = $db->getConnection();

$article = new Article($conn);
$data = $article->getDatabyId($_GET['id']);

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $image = $data['image'];
    if($_FILES['image']['name']){
        // hapus file lagi
        if($image && file_exists('./uploads/'.$image)){
            unlink('./uploads/'. $image);
        }

        // ganti file baru
        $uniqueImage = uniqid()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], './uploads/'. $uniqueImage);
    }
    $article->update($_GET['id'], $_POST['title'], $_POST['content'], $uniqueImage);
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
        <h2>Update Article</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title Article</label>
                <input type="text" name="title" value="<?= $data['title'] ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label class="form-label">Content Article</label>
                <textarea name="content" class="form-control" id=""><?= $data['content'] ?></textarea>
            </div>
            <?php if($data['image']) { ?>
                <p>Current image</p>
                <img src="uploads/<?= $data['image'] ?>" width="200px" height="200px" alt="">
            <?php } ?>
             <div class="mb-3">
                <label class="form-label">Replace Image</label>
                <input type="file" name="image" class="form-control"  >
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>