<?php

class Post {
    // Database 
    private $connection;
    private $table = 'posts';

    // Posts Properties
    public $id;
    public $category_id;
    public $cateogry_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constructor with Database
    public function __construct($database) {
        $this->connection = $database;
    }

    // Get Posts
    public function read() {
        // Create query
        $query = 'SELECT 
                    category.name as category_name, 
                    post.id,
                    post.category_id,
                    post.title,
                    post.body,
                    post.author,
                    post.created_at
                  FROM ' . $this->table . ' post
                       LEFT JOIN categories category ON post.category_id = category.id
                  ORDER BY
                    post.created_at ASC';
        // Prepare statements
        $stmt = $this->connection->prepare($query);

        // Execute the query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Post 
    public function read_post() {
        // Create query
        $query = 'SELECT 
                    category.name as category_name, 
                    post.id,
                    post.category_id,
                    post.title,
                    post.body,
                    post.author,
                    post.created_at
                  FROM ' . $this->table . ' post
                       LEFT JOIN categories category ON post.category_id = category.id
                  WHERE post.id = ?
                  LIMIT 0, 1';

        // Prepare statements
        $stmt = $this->connection->prepare($query);

        // Bind the Post ID from the ? above
        // binding only one, and it's from the ID property
        $stmt->bindparam(1, $this->id);

        // Execute the query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties 
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

        return $stmt;
    }

    // Create Post

    public function create() {
        // Create query for inserting 
        // :title is name parameter for PDO for inserting stuff into DB
        $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';


        // Prepare statement
        $stmt = $this->connection->prepare($query);

        // Sanitize data input
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind the data from the :title, :body, :author, :category_id
        $stmt->bindparam(':title', $this->title);
        $stmt->bindparam(':body', $this->body);
        $stmt->bindparam(':author', $this->author);
        $stmt->bindparam(':category_id', $this->category_id);

        // Execute our query
        if ($stmt->execute()) {
            return true;
        }

        // Print if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
