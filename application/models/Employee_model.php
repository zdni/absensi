<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends MY_Model
{
  protected $table = "employees";

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
    if( !$this->delete_foreign( $data_param, ['employee_activity_model'] ) )
    {
      $this->set_error("gagal");//('group_delete_unsuccessful');
      return FALSE;
    }
    //foreign
    $this->db->trans_begin();

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
  public function employee( $id = NULL  )
  {
      if (isset($id))
      {
        $this->where($this->table.'.id', $id);
      }

      $this->limit(1);
      $this->order_by($this->table.'.id', 'desc');

      $this->employees(  );

      return $this;
  }
  /**
   * employees
   *
   *
   * @return static
   * @author madukubah
   */
  public function employees( $limit = NULL, $start = 0  )
  {
    $this->select('users.*, CONCAT( users.first_name, " ", users.last_name ) as user_fullname');
    $this->select('(SELECT groups.name FROM groups WHERE groups.id = users_groups.group_id) AS group_name');
    $this->select('users_groups.group_id');
    $this->select('users.id AS user_id');
    $this->select('employees.employee_id_number');
    $this->select('employees.id AS employee_id');
    $this->select('positions.name AS position_name');
    $this->select('positions.id AS position_id');
    $this->select('organizations.name AS organization_name');
    $this->select('organizations.id AS organization_id');
    $this->select('religions.name AS religion_name');
    $this->select('religions.id AS religion_id');

      if (isset( $limit ))
      {
        $this->limit( $limit );
      }
      $this->join(
        'users',
        'users.id = employees.user_id',
        'join'
      );
      $this->join(
        'users_groups',
        'users_groups.user_id = employees.user_id',
        'join'
      );
      $this->join(
        'positions',
        'positions.id = employees.position_id',
        'join'
      );
      $this->join(
        'organizations',
        'organizations.id = employees.organization_id',
        'join'
      );
      $this->join(
        'religions',
        'religions.id = employees.religion_id',
        'join'
      );
      $this->offset( $start );
      $this->order_by('users.id', 'asc');
      return $this->fetch_data();
  }

  public function get_employee_by_user_id( $user_id ){
    $this->where( 'users.id', $user_id );

    $this->employees(  );
    return $this;
  }

}
?>
