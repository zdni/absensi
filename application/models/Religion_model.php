<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Religion_model extends MY_Model
{
  protected $table = "religions";

  function __construct() {
      parent::__construct( $this->table );
  }

  public function religion( $id = NULL  )
  {
      if (isset($id))
      {
        $this->where($this->table.'.id', $id);
      }

      $this->limit(1);
      $this->order_by($this->table.'.id', 'desc');

      $this->religions(  );

      return $this;
  }
  
  public function religions( $start = 0 , $limit = NULL )
  {
      if (isset( $limit ))
      {
        $this->limit( $limit );
      }
      $this->offset( $start );
      $this->order_by($this->table.'.id', 'asc');
      return $this->fetch_data();
  }

}
?>
