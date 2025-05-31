<?php
require_once('config/db.php');
require_once('controller/articleController.php');

$db = new Database();
$conn = $db->getConnection();

$article=new Article($conn);
$articles = $article->getAll();

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
        <a href="create.php" class="btn btn-primary btn-sm">Tambah Article</a>
        <h1>Halaman Article</h1>
        <div class="row">
            <?php foreach($articles as $item){ ?>
            <div class="col-4">
                <div class="card" >
                    <div class="card-body">
                        <?php if($item['image']){?>
                            <img src="uploads/<?= $item['image'] ?>" class="card-img-top" alt="...">
                        <?php } else { ?>
                            No Image
                        <?php } ?>
                        <h5 class="card-title"><?= $item['title'] ?></h5>
                        <p class="card-text"><?= $item['content'] ?></p>
                        <a href="update.php?id=<?= $item['id'] ?>" class="card-link text-info">Edit</a>
                        <a href="delete.php?id=<?= $item['id'] ?>" class="card-link text-danger" onclick="return confirm('Yakin ingin hapus?')">Delete</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>