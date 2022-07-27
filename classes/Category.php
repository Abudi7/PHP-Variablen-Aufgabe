<?php 
/**
 * Category
 * 
 * Grouping for articles
 */
class Category {
     
    /**
     * Get all the category
     * 
     * @param object $conn  connction to the database
     * 
     * @return array An associative array of all the article records
     */
    public static function getAll($conn)
    {
        $sql = "SELECT *
            FROM category
            ORDER BY name;";
        
        $results = $conn->query($sql);
        
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

}