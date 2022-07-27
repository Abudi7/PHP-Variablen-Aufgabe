<?php
/**
 * Article
 * 
 * A piece of writing for publication
 */
class Article
{
    /**
     * Unique identifier
     * @var integer
     */
    public $id;
    /**
     * Unique identifier
     * @var string
     */
    public $title;
    /**
     * Unique identifier
     * @var string
     */
    public $content;
    /**
     * Unique identifier
     * @var datatime
     */
    public $published_at;
    /**
     * Path to the image
     * @var string
     */
    public $imageFile;
    /**
     * Unique identifier
     * @var array
     */
    public $errors = [];
    
    /**
     * Get all the articles
     * 
     * @param object $conn  connction to the database
     * 
     * @return array An associative array of all the article records
     */
    public static function getAll($conn)
    {
        $sql = "SELECT *
            FROM article
            ORDER BY published_at;";
        
        $results = $conn->query($sql);
        
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * GET a page of article
     * 
     * @param object $conn Connection to the database
     * @param intger $limit Number of records to return 
     * @param intger $offset Number of records to skip
     * 
     * @return array An associative array of the page of article records
     */
    
    public static function getPage($conn, $limit, $offset , $onlyPublished = false) {
        
        // i creat a where condition to sub query for a article without published time it must be heddin just published article with time 
            //$condition = 'WHERE published_at IS NOT NULL';
        //So, we'll use the ternary operator to return the condition string if the argument is true
            $condition = $onlyPublished ? 'WHERE published_at IS NOT NULL' : '';

        //this query to display all record that have a category name i rename the split category.name as category_name to use it in array  
        $sql = "SELECT a.*,category.name AS category_name FROM (SELECT * FROM article $condition
                ORDER BY published_at 
                LIMIT :limit
                OFFSET :offset) AS a
                LEFT JOIN article_category ON a.id = article_category.article_id
                LEFT JOIN category ON article_category.category_id = category.id ";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit',$limit, PDO::PARAM_INT); 
        $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
        $stmt->execute(); 
        //we create a varible to get the result from fetchall(pdo::query)
        $results =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        //we save the alle category below the record in new array 
        $articles = [];
        // i let the previousid to null at the first 
        $previousID = null;
        /**
         * we can see that each article has a new element

        * for the category names.

        * And if the article is related to more than one category,

        * this element contains multiple values.

        * can display the categories in the index page.

        * So, instead of printing out the category name element,
         */
        foreach ($results as $row ) {
            $articleId = $row['id'];
            //If the id is the same, we don't add it. Then at the end of the loop, we set the previous id to the current one. Then at the end of the function, let's return the new array.Now in the browser, we only get the articles once,so 4 per page.
            if ($articleId != $previousID) {
                //i can add the categories to each article in the new array.If this is a new article,let's add an array element to the row for the category names
                $row['category_names'] = [];

                $articles[$articleId] = $row;
            }

            $articles[$articleId]['category_names'][]= $row['category_name'];

            $previousID = $articleId;
        }
        return $articles;
    }
    
    
    /**
     * Get the article record based on the ID
     *
     * @param object $conn Connection to the database
     * @param integer $id the article ID
     *
     * @return mixed An associative array containing the article with that ID, or null if not found
     */
    public static function getByID($conn, $id)
    {
        $sql = "SELECT *
                FROM article
                WHERE id = :id";
        
        $stmt = $conn->prepare($sql);
        //$stmt = mysqli_prepare($conn, $sql);
        
        /*if ($stmt === false) {
        
        echo mysqli_error($conn);
        
        } else {*/
        
        //mysqli_stmt_bind_param($stmt, "i", $id);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        // to return an object instead of an array i have to use setFetchMode
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');
        
        if ($stmt->execute()) /*(mysqli_stmt_execute($stmt))*/ {
            
            //i can replace these two mysqli lines with one PDO line more easier.
            /*$result = mysqli_stmt_get_result($stmt);  
            
            return mysqli_fetch_array($result, MYSQLI_ASSOC);*/
            return $stmt->fetch();
            
        }
        
    }

    /**
     * Get the article recod based on the ID along with associated category, if any
     * 
     * @param object $conn Connection to the databse 
     * @param integer $id The article ID 
     * 
     * @return array the article data with categories
     */
    public static function getWithCategories($conn , $id , $onlyPublished = false) {
        $sql = "SELECT article.*, category.name AS category_name
                FROM `article`
                LEFT JOIN article_category
                ON article.id = article_category.article_id
                LEFT JOIN category 
                ON article_category.category_id = category.id
                WHERE article.id = :id";

        if ($onlyPublished) {
            $sql .=' AND article.published_at IS NOT NULL';
        }
        
        $stmt = $conn->prepare($sql);  
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    /**
     * Get article categories
     * 
     * @param object $conn Connection to the database 
     * 
     * @return array The category data
     */

    public function getCategories($conn) {
        $sql = "SELECT category.*
                FROM category
                JOIN article_category
                ON category.id = article_category.category_id
                WHERE article_id = :id";
        
        $stmt =$conn->prepare($sql);
        $stmt->bindValue(":id",$this->id,PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update the article with its currnt property values
     * 
     * @param object $conn connection to the database 
     * 
     * @return boolen true if the update was successful, fals otherwise 
     * 
     */
    public function update($conn)
    {
        if ($this->validate()) {
            $sql = "UPDATE article
            SET title = :title,
                content = :content,
                published_at = :published_at
            WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }
            return $stmt->execute();
        } else {
            return false;
        }
    }
    /**
     * Set the Category 
     * 
     * @param object $conn Connction to the database´
     * @param array $ids Category IDS
     * 
     * @return void   
     */
    /*public function setCategories($conn , $ids) {
        // The array of category ids could be empty, so we'll check for that
        if ($ids) {
            //Insert Article Categories more Efficiently using a Multi Query
            //$sql = "INSERT IGNORE INTO article_category (article_id, category_id) 
                    //VALUES ({$this->id} , :category_id)";

            //Insert Article Categories more Efficiently using a Single Query
            //delete the first all varible from value 
            $sql = "INSERT IGNORE INTO article_category (article_id, category_id) 
                    VALUES ";
            // creat a array call $values 
            $values = [];
            
            // second add a loop for the category ids array.Inside this loop we'll create a string with each set of values

            foreach ($ids as $id) {
                $values[] = "({$this->id}, ?)";
            }
            //thierd call the func implode()   Join array elements with a string

            $sql .= implode(", ", $values); 
            // to check if the stmt right i put var_dump + die()
        

            $stmt = $conn->prepare($sql);
             //when i bind the values instead of the placeholder name,i can identify the placeholder by the one indexed position of the parameter.
            //That is the first parameter is one, the second is two and so on.
            foreach ($ids as $i => $id) { 
                $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
            }
          
            $stmt->execute())
            
        } 
    }*/
    public function setCategories($conn, $ids)
    {
        if ($ids) {
            try{
                    $sql = "INSERT IGNORE INTO article_category (article_id, category_id)
                            VALUES ";

                    $values = [];

                    foreach ($ids as $id) {
                        $values[] = "({$this->id}, ?)";
                    }

                    $sql .= implode(", ", $values);

                    $stmt = $conn->prepare($sql);

                    foreach ($ids as $i => $id) {
                        $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
                    }

                    $stmt->execute();
                } catch (Excption $e) {
                    die($e->getMessage());
                }
            }

                $sql = "DELETE FROM article_category
                        WHERE article_id = {$this->id}";

                if ($ids) {

                    $placeholders = array_fill(0, count($ids), '?');

                    $sql .= " AND category_id NOT IN (" . implode(", ", $placeholders) . ")";

                }

                $stmt = $conn->prepare($sql);

                foreach ($ids as $i => $id) {
                    $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
    }

    
    /**
     * Validate the properties,putting any validation error messages in the $errors property
     *
     *
     * @return array An array of validation error messages
     */
    protected function validate()
    {
        
        
        if ($this->title == '') {
            $this->errors[] = 'Title is required';
        }
        if ($this->content == '') {
            $this->errors[] = 'Content is required';
        }
        
        if ($this->published_at != '') {
            $dateTime = date_create_from_format('Y-m-d\TH:i', $this->published_at);
            
            if ($dateTime === false) {
                
                $this->errors[] = 'Invalid date and time';
                
            } else {
                
                $date_errors = date_get_last_errors();
                
                if ($date_errors['warning_count'] > 0) {
                    $this->errors[] = 'Invalid date and time';
                }
            }
        }
        
        return empty($this->errors);
    }
    /**
     * Delete the current article
     *
     * @param object $conn Connection to the database
     *  
     * @return boolen True if the delete was successful, false otherwise
     */
    public function delete($conn)
    {
        $sql = "DELETE FROM article
                WHERE id = :id";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    /**
     * Insert a new Article with its current property values
     * 
     * @param object $conn connection to the database 
     * 
     * @return boolen true if the update was successful, fals otherwise 
     * 
     */
    public function create($conn)
    {
        if ($this->validate()) {
            $sql = "INSERT INTO `article`(`title`, `content`, `published_at`) 
                        VALUES (:title, :content, :published_at)";
            
            $stmt = $conn->prepare($sql);
            
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }
            
            if ($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * GET a count of the total number of records
     * 
     * @param object $conn connction to the database 
     * 
     * @return integer the total number of records 
     */
    public static function getTotal($conn, $onlyPublished = false) {
        //First, add an optional argument to restrict to published articles only and insert this into the sql
        $condition = $onlyPublished ? 'WHERE published_at IS NOT NULL' : '';

        //return value directly 
        return $conn->query("SELECT COUNT(*) FROM article $condition")->fetchColumn();
    }

    /**
     * Update the image file property
     * 
     * @param object $conn Connection to the database
     * @param string $filename the filename of the imag file 
     * 
     * @return boolean True if it was successful, flase otherwise
     */
    public function setImageFile($conn , $filename) {
        $sql = "UPDATE article 
                SET image_file = :image_file
                WHERE id =:id";
    
        $stmt = $conn->prepare($sql);
        //Execute a prepared statement by binding PHP variables
        $stmt->bindValue(':id',$this->id,PDO::PARAM_INT);
        $stmt->bindValue(':image_file', $filename ,$filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        
        return $stmt->execute();
        
    }

    /**
     * publish the article, setting the published_at field to the current data and time 
     * 
     * @param object $conn Connection to the database 
     * 
     * @return mixed the published_at data and time if successful, null otherwise
     */
    public function publish($conn) {

        $sql = "UPDATE article 
                SET published_at = :published_at
                WHERE id = :id" ;

        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(':id' , $this->id , PDO::PARAM_INT);
        $published_at = date("Y-m-d H:i:s");

        $stmt->bindValue(':published_at' , $published_at , PDO::PARAM_STR);

        if($stmt->execute()) {
            return $published_at;
        }
    }
}

?>