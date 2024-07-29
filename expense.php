<?php
include_once 'config.php';

class Expense {
    private $conn;
    private $table_name = "expenses";

    public $id;
    public $amount;
    public $method;
    public $description;
    public $name;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query1 = "SELECT `id` FROM `users` WHERE `name`='$this->name' ";
        $stmt1 = $this->conn->prepare($query1);
        if ($stmt1->execute()) {
            while($_row=$stmt1->fetch()){
                $user_id=$_row['id'];
            }

            $query = "INSERT INTO  $this->table_name (`amount`, `method`, `description`,`user_id`) VALUES ('$this->amount', '$this->method', '$this->description','$user_id')";
            $stmt = $this->conn->prepare($query);

            // $this->amount = htmlspecialchars(strip_tags($this->amount));
            // $this->method = htmlspecialchars(strip_tags($this->method));
            // $this->description = htmlspecialchars(strip_tags($this->description));

            // $stmt->bindParam(":amount", $this->amount);
            // $stmt->bindParam(":method", $this->method);
            // $stmt->bindParam(":description", $this->description);

            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    function read() {
        $query = "SELECT * FROM  $this->table_name ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}

$database = new Database();
$db = $database->getConnection();

$expense = new Expense($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    $expense->amount = $data->amount;
    $expense->method = $data->method;
    $expense->description = $data->description;
    $expense->name = $data->name;

    if ($expense->create()) {
        echo json_encode(["message" => "Expense added successfully"]);
    } else {
        echo json_encode(["message" => "Unable to add expense"]);
    }
} 
else {
    $stmt = $expense->read();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $expenses_arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $expense_item = [
                "id" => $id,
                "amount" => $amount,
                "method" => $method,
                "description" => $description,
                "user_id" => $user_id
            ];
            array_push($expenses_arr, $expense_item);
        }
        echo json_encode($expenses_arr);
    } else {
        echo json_encode([]);
    }
}
?>
