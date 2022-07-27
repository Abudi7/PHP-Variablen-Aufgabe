<?php
/**
 * Paginator 
 * 
 * Data for selecting a page of records
 */
class Paginator {
    /**
     * Number of records to return 
     * @var intger 
     */
    public $limit;
    /**
     * Number of records to skip before the page  
     * @var intger 
     */
    public $offset;
    /**
     * Previous page number 
     * @var intger 
     */
    public $previous;
    /**
     * Next page number
     * @var intger 
     */
    public $next;
    /**
     * Constructor
     * 
     * @param integer $page Page number 
     * @param integer $reccordsPerPage of records per Page 
     * 
     * @return void 
     */

    public function __construct($page, $recordsPerPage, $totalRecords) {

        $this->limit  = $recordsPerPage;
        
        //var_dump($page);
        //echo"<br>";
        $page = filter_var($page,FILTER_VALIDATE_INT,['options' => ['default' => 1,'min_range' => 1]]);
        //var_dump($page);
        $this->offset = $recordsPerPage * ($page-1);
        //the previous page - 1
        if ($page > 1 ) {
            $this->previous = $page - 1;
        }
        $totalPages = ceil($totalRecords / $recordsPerPage);

        if ($page < $totalPages) {

             //the next page + 1
             $this->next = $page + 1;

        }
       
    } 
}
?>