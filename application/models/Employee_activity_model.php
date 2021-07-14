<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_activity_model extends MY_Model
{
  protected $table = "employee_activity";

  function __construct() {
      parent::__construct( $this->table );
      parent::set_join_key( 'employee_id' );
  }

  /**
   * create
   *
   * @param array  $data
   * @return static
   * @author madukubah
   */
  public function create( $data )
  {
      // Filter the data passed
      $data = $this->_filter_data($this->table, $data);

      $this->db->insert($this->table, $data);
      $id = $this->db->insert_id($this->table . '_id_seq');
    
      if( isset($id) )
      {
        $this->set_message("berhasil");
        return $id;
      }
      $this->set_error("gagal");
          return FALSE;
  }
  /**
   * update
   *
   * @param array  $data
   * @param array  $data_param
   * @return bool
   * @author madukubah
   */
  public function update( $data, $data_param  )
  {
    $this->db->trans_begin();
    $data = $this->_filter_data($this->table, $data);

    $this->db->update($this->table, $data, $data_param );
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();

      $this->set_error("gagal");
      return FALSE;
    }

    $this->db->trans_commit();

    $this->set_message("berhasil");
    return TRUE;
  }
  /**
   * delete
   *
   * @param array  $data_param
   * @return bool
   * @author madukubah
   */
  public function delete( $data_param  )
  {
    $this->db->delete($this->table, $data_param );
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();

      $this->set_error("gagal");//('group_delete_unsuccessful');
      return FALSE;
    }

    $this->db->trans_commit();

    $this->set_message("berhasil");//('group_delete_successful');
    return TRUE;
  }

    /**
   * group
   *
   * @param int|array|null $id = id_groups
   * @return static
   * @author madukubah
   */
  public function employee_activity( $id = NULL  )
  {
      if (isset($id))
      {
        $this->where($this->table.'.id', $id);
      }

      $this->order_by($this->table.'.id', 'desc');

      $this->employee_activities(  );

      return $this;
  }
  /**
   * employees
   *
   *
   * @return static
   * @author madukubah
   */
  public function employee_activities( $limit = NULL, $start = 0  )
  {
    $this->offset( $start );
    $this->order_by($this->table . '.id', 'asc');
    return $this->fetch_data();
  }

  public function get_total_minutes_work( $employee_id = NULL, $state_id = NULL, $activity_id = NULL ) {
    $this->select( 'SUM( minutes ) AS total_minutes' );
    if (isset($employee_id))
    {
      $this->where($this->table.'.employee_id', $employee_id);
    }
    if (isset($state_id))
    {
      $this->where($this->table.'.state_id', $state_id);
    }
    if (isset($activity_id))
    {
      $this->where($this->table.'.activity_id', $activity_id);
    }
    $this->employee_activities(  );
    return $this;
  }
  
  public function employee_activity_where_clause( $employee_id = NULL, $state_id = NULL, $activity_id = NULL ) {
    if (isset($employee_id))
    {
      $this->where($this->table.'.employee_id', $employee_id);
    }
    if (isset($state_id))
    {
      $this->where($this->table.'.state_id', $state_id);
    }
    if (isset($activity_id))
    {
      $this->where($this->table.'.activity_id', $activity_id);
    }
    $this->employee_activities(  );
    return $this;
  }

  public function get_total_employee_activity( $employee_id = NULL, $state_id = NULL, $activity_id = NULL ) {
    $this->select( 'COUNT(*) AS total_employee_activity' );
    $this->employee_activity_where_clause( $employee_id, $state_id, $activity_id );
    return $this;
  }

  public function employee_activity_by_date( $employee_id = NULL, $start_date = NULL, $end_date = NULL ) {
    $this->select( $this->table . '.employee_id' );
    $this->select( $this->table . '.activity_id' );
    $this->select( $this->table . '.checked_employee_id' );
    $this->select( $this->table . '.state_id' );
    $this->select( $this->table . '.date' );
    $this->select( $this->table . '.end_time' );
    $this->select( 'activities.name AS activity_name' );
    $this->select( 'activity_state.color AS color' );
    // $this->select('users.*, CONCAT( users.first_name, " ", users.last_name ) as user_fullname');
    // $this->select( 'employee.' );
    $this->join(
      'activities',
      'activities.id = employee_activity.activity_id',
      'join'
    );
    $this->join(
      'activity_state',
      'activity_state.id = employee_activity.state_id',
      'join'
    );
    // $this->join(
    //   'employee',
    //   'employee.id = employee_activity.checked_employee_id',
    //   'join'
    // );

    if (isset($employee_id))
    {
      $this->where($this->table.'.employee_id', $employee_id);
    }
    if (isset($start_date) && isset($end_date))
    {
      $this->where($this->table.'.date >=', $start_date);
      $this->where($this->table.'.date <=', $end_date);
    }
    $this->employee_activities(  );
    return $this;
  }
}
?>
