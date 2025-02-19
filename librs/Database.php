<?php
class Database
{
  protected $conn;
  protected $table = "";

  function __construct()
  {
    $this->conn = mysqli_connect(HOST, USER, PASSWORD, DB);
    if (!$this->conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_set_charset($this->conn, "utf8");
  }

  public static function select($select = "*")
  {
    $_this = new static();
    $result = [];
    $sql = "SELECT {$select} FROM `{$_this->table}` WHERE 1";
    $query = $_this->conn->query($sql);
    while ($row = $query->fetch_object()) {
      $result[] = $row;
    }
    return $result;
  }

  public static function find($data, $select = "*")
  {
    $_this = new static();
    $rule = "";
    foreach ($data as $key => $value) {
      $rule .= "`$key` = '$value' AND ";
    }
    $rule = rtrim($rule, "AND ");
    $sql = "SELECT {$select} FROM `{$_this->table}` WHERE {$rule} LIMIT 1";
    $query = $_this->conn->query($sql);
    $_this->conn->close();
    return $query->fetch_object();
  }

  public static function finds($data = null, $offset = null, $limit = null)
  {
    $_this = new static();
    $result = [];
    $rule = "";

    if ($data) {
      // Tạo điều kiện WHERE từ mảng `$data`
      foreach ($data as $key => $value) {
        $rule .= "`$key` = '$value' AND ";
      }
      $rule = rtrim($rule, "AND ");
    }

    // Xây dựng câu lệnh SQL
    $sql = "SELECT * FROM `{$_this->table}`";
    if (!empty($rule)) {
      $sql .= " WHERE {$rule}";
    }

    // Thêm điều kiện phân trang nếu `$offset` và `$limit` được truyền vào
    if ($offset !== null && $limit !== null) {
      $sql .= " LIMIT {$offset}, {$limit}";
    }

    // Thực thi truy vấn
    $query = $_this->conn->query($sql);

    if ($query) {
      while ($row = $query->fetch_object()) {
        $result[] = $row;
      }
    }

    // Đóng kết nối và trả kết quả
    $_this->conn->close();
    return $result;
  }


  public static function countRows($data)
  {
    $_this = new static();
    $rule = "";

    // Tạo điều kiện WHERE từ mảng `$data`
    foreach ($data as $key => $value) {
      $rule .= "`$key` = '$value' AND ";
    }
    $rule = rtrim($rule, "AND ");

    // Câu lệnh SQL đếm số dòng
    $sql = "SELECT COUNT(*) as total FROM `{$_this->table}` WHERE {$rule}";
    $query = $_this->conn->query($sql);

    if ($query) {
      $result = $query->fetch_object();
      $_this->conn->close();
      return $result->total; // Trả về tổng số dòng
    }

    $_this->conn->close();
    return 0; // Trả về 0 nếu không có kết quả
  }

  public static function countRowAll()
  {
    $_this = new static();

    // Câu lệnh SQL đếm số dòng
    $sql = "SELECT COUNT(*) as total FROM `{$_this->table}` WHERE 1";
    $query = $_this->conn->query($sql);

    if ($query) {
      $result = $query->fetch_object();
      $_this->conn->close();
      return $result->total; // Trả về tổng số dòng
    }

    $_this->conn->close();
    return 0; // Trả về 0 nếu không có kết quả
  }


  public static function findsWithOr($data)
  {
    $_this = new static();
    $result = [];
    $rule = "";
    foreach ($data as $key => $value) {
      $rule .= "`$key` = '$value' OR ";
    }
    $rule = rtrim($rule, "OR ");
    $sql = "SELECT * FROM `{$_this->table}` WHERE {$rule}";
    $query = $_this->conn->query($sql);
    $_this->conn->close();
    while ($row = $query->fetch_object()) {
      $result[] = $row;
    }
    return $result;
  }

  public static function create($data)
  {
    $_this = new static();
    $keys = array_keys($data);
    $keys = implode("`, `", $keys);
    $values = array_values($data);
    $values = implode("', '", $values);
    $sql = "INSERT INTO `{$_this->table}` (`$keys`) VALUES ('$values')";
    $query = $_this->conn->query($sql);
    $_this->conn->close();
    return $query;
  }


  public static function update($id, $data)
  {
    $_this = new static();
    $keyID = array_keys($id);
    $valueID = array_values($id);
    $sql = "UPDATE `{$_this->table}` SET ";
    foreach ($data as $key => $value) {
      $sql .= "`$key` = '$value', ";
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE `$keyID[0]` = '$valueID[0]'";
    $query = $_this->conn->query($sql);
    $_this->conn->close();
    return $query;
  }

  public static function delete($id)
  {
    $_this = new static();
    $keyID = array_keys($id)[0];
    $valueID = array_values($id)[0];
    $sql = "DELETE FROM `{$_this->table}` WHERE `$keyID` = '$valueID'";
    $query = $_this->conn->query($sql);
    $_this->conn->close();
    return $query;
  }

  public static function findWithTbl($table, $data)
  {
    $_this = new static();
    $keys = array_keys($data);
    $values = array_values($data);
    $sql = "SELECT * FROM `{$table}` WHERE `$keys[0]` = '$values[0]' LIMIT 1";
    $query = $_this->conn->query($sql);
    $_this->conn->close();
    return $query->fetch_object();
  }

  public static function createResultId($data, $table = '')
  {
    $_this = new static();
    if ($table == '') {
      $table = $_this->table;
    }
    $keys = array_keys($data);
    $keys = implode("`, `", $keys);
    $values = array_values($data);

    $params = implode(", ", array_fill(0, count($data), "?"));

    $sql = "INSERT INTO `$table` (`$keys`) VALUES ($params)";
    $stmt = $_this->conn->prepare($sql);

    if (!$stmt) {
      die('Error: ' . $_this->conn->error);
    }

    $types = str_repeat('s', count($data));
    $stmt->bind_param($types, ...$values);

    $stmt->execute();

    // Trả về ID của bản ghi vừa được tạo
    return $_this->conn->insert_id;
  }
}
