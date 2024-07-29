<?php
include_once 'config.php';

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $mobile;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, mobile=:mobile";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile", $this->mobile);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->name = $data->name;
$user->email = $data->email;
$user->mobile = $data->mobile;

if ($user->create()) {
    echo json_encode(["message" => "User created successfully"]);
} else {
    echo json_encode(["message" => "Unable to create user"]);
}
?>
