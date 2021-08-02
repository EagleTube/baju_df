<?php
class dbexec
{
    public $id;
    public $shopee;
    public $name;
    public $package;
    public $quantity;
    public $size;
    public $date;
    public $sleeve;
    private $message;
    static protected $host = "localhost";
    static protected $user = "root";
    static protected $pass = "";
    static protected $db = "baju_df";

    public static function connectDb()
    {
        $db = new mysqli(self::$host,self::$user,self::$pass,self::$db);
        return $db;
    }

    public function customer()
    {
        $cmd = "INSERT INTO customer VALUES('$this->id','$this->shopee','$this->name','$this->date')";
        $query = static::connectDb()->query($cmd);
        if(!static::connectDb()->error)
        {
            $this->orders($this->size,$this->sleeve,$this->id,$this->quantity,$this->package);
        }
    }
    public function orders($size_id,$sid,$cust_id,$quantity,$pid)
    {
        $cmd = "INSERT INTO orders(order_id,size_id,sid,cust_id,quantity,package_id) VALUES(NULL,'$size_id','$sid','$cust_id','$quantity','$pid')";
        $query = static::connectDb()->query($cmd);
        if(!static::connectDb()->error)
        {
            $this->message = "Successfully added!";
            echo $this->message;
        }
        else
        {
            die($this->$sql->error);
        }
    }
    public static function AddData()
    {
        $instance = new dbexec();
        return $instance->customer();
    }

    public static function display()
    {
        $instance = new dbexec();
        $cmd = "SELECT customer.cust_id AS 'Customer_Id',customer.shopee_user AS 'Shopee_User',
                customer.name AS 'Customer_Name',package.type AS 'Package',package_size.size AS 'Size',
                sleeves.stype 'Sleeve',orders.quantity AS 'Quantity',(orders.quantity*(pricing.price+additONal_pricing.price)) AS 'Price',
                customer.date AS 'Date' from customer JOIN orders ON orders.cust_id=customer.cust_id JOIN package ON 
                orders.package_id=package.package_id JOIN package_size ON orders.size_id=package_size.size_id JOIN sleeves ON 
                orders.sid=sleeves.sid JOIN pricing ON pricing.package_id=package.package_id AND pricing.sid=sleeves.sid JOIN 
                additONal_pricing ON additONal_pricing.size_id=package_size.size_id";

        $display = $instance::connectDb()->query($cmd);
        return $display;
    }
    public static function Package()
    {
        $instance = new dbexec();
        $cmd = "SELECT * FROM package";
        $display = $instance::connectDb()->query($cmd);
        return $display;
    }
    public static function PackageSize()
    {
        $instance = new dbexec();
        $cmd = "SELECT * FROM package_size";
        $display = $instance::connectDb()->query($cmd);
        return $display;
    }
    public static function Sleeves()
    {
        $instance = new dbexec();
        $cmd = "SELECT * FROM sleeves";
        $display = $instance::connectDb()->query($cmd);
        return $display;
    }
}


