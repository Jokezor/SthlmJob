<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sample page</h1>
<?php






$_REDSHIFT_SERVERS = array(
  'host_1' => array(
    'host' => 'basedb.cilpan63byk8.eu-central-1.redshift.amazonaws.com',
    'port' => 5439,
    'dbname' => 'dev',
    'user' => 'sthlmjob_1_win',
    'password' => 'sthlmjob_1_Pass',
    'options' => '--client_encoding=UTF8',
  )
);


class Connection {

  public static $connections = array();
  private $connectionString = null;
  private $connection = null;

  final private function __construct($connection,$database){
    $servers = $_REDSHIFT_SERVERS;
    if(!isset($servers[$connection])){
      throw new \Exception('Could not find redshift server configuration information for "'.$connection.'"');
    }
    $server = $servers[$connection];
    $connectionString = '';
    foreach($server as $k => $v){
      if(($k == 'dbname') && ($database != 'default')){
        //override db.
        $v = $database;
      }
      $connectionString .= $k.'='.$v.' ';
    }
    $this->connectionString = (strlen($connectionString)>0)? substr($connectionString,0,-1) : '';
    $this->connect($this->connectionString);
  }



  final private function __clone(){}

  public static function getInstance($connection='default',$database='default'){
    $instancePoolName = 'c:'.$connection.',d:'.$database;
    if(!isset(self::$connections[$instancePoolName])){
      self::$connections[$instancePoolName] = new self($connection,$database);
    }
    return self::$connections[$instancePoolName];
  }



  public function connect($connectionString){
    $this->connection = \pg_connect($connectionString);
    if(!$this->connection){
      throw new \Exception('Failed to connect: '.\pg_last_error($this->connection));
    }
  }


  public function exec($query){
    $result = @\pg_query($this->connection,$query);
    if($result){
      return $result;
    } else {
      throw new \Exception('Failed to exec query: '.\pg_last_error($this->connection));
    }
  }


  public function __destruct(){
    @\pg_close($this->connection);
  }


  public function reset(){
    @\pg_close($this->connection);
    $this->connect($this->connectionString);
  }

}


$connection = Connection::getInstance('host_1','basedb');
$results = $connection->exec('SELECT * FROM sales WHERE sales.dateid = date.dateid');
echo $_REDSHIFT_SERVERS["salesid"]

?>
</body>
</html>
