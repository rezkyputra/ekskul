<?php

class Article{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($title, $content, $image){
        $newArticle = $this->conn->prepare("INSERT INTO article (title, content, image) values (?, ?, ?)");
        return $newArticle->execute([$title, $content, $image]);
    }

    public function getAll(){
        $articles = $this->conn->prepare("SELECT * FROM article");
        $articles->execute();
        return $articles;
    }

    public function getDatabyId($id){
        $article = $this->conn->prepare("SELECT * FROM article WHERE id = ?");
        $article->execute([$id]);
        return $article->fetch(PDO::FETCH_ASSOC);
    }

     public function update($id, $title, $content, $image = null){
        if($image){
            $newArticle = $this->conn->prepare("UPDATE article SET title = ?, content = ?, image = ? WHERE id = ?");
            return $newArticle->execute([$title, $content, $image, $id]);
        }else{
            $newArticle = $this->conn->prepare("UPDATE article SET title = ?, content = ?, WHERE id = ?");
            return $newArticle->execute([$title, $content, $id]);
        }
    }
    
    public function delete($id){
        $data = $this->getDatabyId($id);

        // hapus file di folder uploads
        $image = $data['image'];
        if($data && $image && file_exists('./uploads/'. $image)){
            unlink('./uploads/'.$image);
        }

        // hapus data di Database
        $Article = $this->conn->prepare("DELETE FROM article WHERE id = ?");
        return $Article->execute([$id]);
    }
}