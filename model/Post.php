<?php

class Post {

    //DB Details
    public $db;
    public $table = 'posts';

    //post Details
    public $id ;
    public $category_id ;
    public $title;
    public $body;
    public $author ;
    public $created_at;
    public $category;

    public function __construct($db){
        $this->db = $db; 
    }
    public function get(){
        $query = 'SELECT c.name, p.* from '. $this->table .' p join categories c on p.category_id = c.id';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($result, $row);
        }
        return $result;
    }

    public function get_post(){
        $query = 'SELECT c.name, p.* from '. $this->table .' p join categories c on p.category_id = c.id where
        p.id=?';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->category_id = $row['category_id'];
        $this->category = $row['name'];
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->created_at = $row['created_at'];

        return $this;
    }

    public function create_post(){
        $query1 = 'select c.id from categories c where c.name =?';
        $stmt = $this->db->prepare($query1);
        $stmt->bindParam(1, $this->category);
        $stmt->execute();
        $category_id = $stmt->fetch(PDO::FETCH_COLUMN);

        $query2 = 'insert into '.$this->table. '(category_id, title, body, author) values (?, ?, ?,?)';
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bindParam(1,$category_id);
        $stmt2->bindParam(2,$this->title);
        $stmt2->bindParam(3,$this->body);
        $stmt2->bindParam(4,$this->author);

        $stmt2->execute();
        return $this->get_post($this->db->lastInsertId());
    }

    public function update_post(){
        $query = 'update '.$this->table. ' SET category_id =? , title =?, body =?, author =?
        where id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1,$this->category_id);
        $stmt->bindParam(2,$this->title);
        $stmt->bindParam(3,$this->body);
        $stmt->bindParam(4,$this->author);
        $stmt->bindParam(5,$this->id);

        $stmt->execute();
        return $this->get_post($this->id);
    }

    public function delete_post(){
        $query = 'delete from '.$this->table . ' where id = ? limit 1';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1,$this->id);
        if ($stmt->execute())
            return true;
        else
            echo "error" . $stmt->error;
    }
}
?>