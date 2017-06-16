<?php
class Book{
  private $db;
  private $error = array();
  private $adult = array();
  private $child = array();
  private $snr_male = array();
  private $snr_female = array();
  private $source;
  private $destination;
  private $a_time;
  private $d_time;
  private $passenger_list = array();
  private $boarding_point;

  public function __construct($_db, $source = null, $destination = null, $arrival_time = null, $deparature_time = null){
    $this->db = $_db;
    $this->source = $source;
    $this->destination = $destination;
    $this->a_time = $arrival_time;
    $this->d_time = $deparature_time;
    if(isset($_POST['get-details'])) $this->get_passenger_details();
    if(isset($_POST['finish-details'])) $this->get_passenger_names();
  }

  public function get_passenger_details(){
    $this->adult = $this->db->real_escape_string($_POST['adult']);
    $this->child = $this->db->real_escape_string($_POST['child']);
    $this->snr_male = $this->db->real_escape_string($_POST['snr-male']);
    $this->snr_female = $this->db->real_escape_string($_POST['snr-female']);
    $_SESSION['passenger'] = array(
      'adult' => $this->adult,
      'child' => $this->child,
      'snr-male' => $this->snr_male,
      'snr-female' => $this->snr_female,
      'source' => $this->source,
      'destination' => $this->destination,
      'a-time' => $this->a_time,
      'd-time' => $this->d_time
    );
    echo '<script>window.location="./get-passenger-info.php"</script>';
    exit();

  }
  public function get_passenger_names(){
    $ticket = $this->save_ticket_details();
    if(isset($_POST['name-adult'])){
      foreach ($_POST['name-adult'] as $key => $value) {
        $id = $this->get_max_passenger_no();
        $age = $_POST['age-adult'][$key];
        $gender = $_POST['gender-adult'][$key];
        $query = "insert into passenger (id,name,type,age,gender,ticket)";
        $query .= "values('$id','$value','adult','$age','$gender','$ticket')";
        $this->db->query($query);
      }
    }
      if(isset($_POST['name-child'])){
        foreach ($_POST['name-child'] as $key => $value) {
          $id = $this->get_max_passenger_no();
          $age = $_POST['age-child'][$key];
          $gender = $_POST['gender-child'][$key];
          $query = "insert into passenger (id,name,type,age,gender,ticket)";
          $query .= "values('$id','$value','child','$age','$gender','$ticket')";
          $this->db->query($query);
        }
      }
      if(isset($_POST['name-snr-male'])){
        foreach ($_POST['name-snr-male'] as $key => $value) {
          $id = $this->get_max_passenger_no();
          $age = $_POST['age-snr-male'][$key];
          $gender = $_POST['gender-snr-male'][$key];
          $query = "insert into passenger (id,name,type,age,gender,ticket)";
          $quert .= "values('$id','$value','snr-male','$age','$gender','$ticket')";
          $this->db->query($query);
        }
      }
      if(isset($_POST['name-snr-female'])){
        foreach ($_POST['name-snr-female'] as $key => $value) {
          $id = $this->get_max_passenger_no();
          $age = $_POST['age-snr-female'][$key];
          $gender = $_POST['gender-snr-female'][$key];
          $query = "insert into passenger (id,name,type,age,gender,ticket)";
          $quert .= "values('$id','$value','snr-female','$age','$gender','$ticket')";
          $this->db->query($query);
        }
      }
    /*$_SESSION['adult'] = $this->adult;
    $_SESSION['child'] = $this->child;
    $_SESSION['snr-male'] = $this->snr_male;
    $_SESSION['snr-female'] = $this->snr_female;*/
    echo '<script>window.location="./ticket-result.php"</script>';
    exit();
  }
  public function save_ticket_details(){
    $id = $this->get_max_ticket_no();
    $pnr = rand(1000000000,9999999999);
    $no_of_passenger = $this->get_num_of_passenger();
    $a_time = "'".$_SESSION['passenger']['a-time']."'";
    $d_time = "'".$_SESSION['passenger']['d-time']."'";
    $source = "'".$_SESSION['passenger']['source']."'";
    $username = "'".$_SESSION['username']."'";
    $destination = "'".$_SESSION['passenger']['destination']."'";
    $query = "insert into ticket (id,source,destination,a_time,d_time,no_of_passenger,username,pnr)";
    $query .= 'values ('.$id.','.$source.','.$destination.',';
    $query .= ''.$a_time.','.$d_time.','.$no_of_passenger.','.$username.','.$pnr.')';
    if($this->db->query($query) === true){
      $this->msg[] = 'Ticket saved';
    } else $this->msg[] = 'something wrong';
    return $id;
  }
  public function get_num_of_passenger(){
    $no_of_passenger = $_SESSION['passenger']['adult']+$_SESSION['passenger']['child']+$_SESSION['passenger']['snr-male']+$_SESSION['passenger']['snr-female'];
    return $no_of_passenger;
  }
  public function get_max_ticket_no(){
    $query = "select max(id) as max_id from ticket";
    $result = $this->db->query($query)->fetch_object();
    return ($result->max_id +1 );
  }
  public function get_max_passenger_no(){
    $query = "select max(id) as max_id from passenger";
    $result = $this->db->query($query)->fetch_object();
    return ($result->max_id +1 );
  }

  public function write_passenger_form(){
    $info = $_SESSION['passenger'];
    for($i=0; $i<$info['adult'];$i++){

    }
  }

  public function display_errors(){
    foreach($this->error as $error){
      echo '<p style="color:red; font-size:16px; margin-top:30px; margin-left:50px">'.$error.'</p>';
    }
  }
  public function get_destination(){
    return $this->destination;
  }
}
 ?>
