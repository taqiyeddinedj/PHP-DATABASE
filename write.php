<?php
$server_name='localhost';
$user_name='root';
$password='';
$dbname='test';

//create a connection 
$con=mysqli_connect($server_name,$user_name,$password,$dbname);

//check connection

if(!$con){
    die ("error, not getting a connection!".mysqli_connect_errno());

}
else{
    echo "Connection created to $dbname";
}

//sql to create a table
$sql = "CREATE TABLE table5 (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50)
    )";

//echo the result 
if (mysqli_query($con,$sql)){
    echo "Table created succesfully!";
}
else {
    echo "Error creataing the table: " .mysqli_error($con);
}



///////// INSERTIO TO THE TABLE WITH BEST PRACTICE 
///we need to prepare the statment with placeholders for our values 
    // TO protect against SQL INJECTION we seperate our code from the user's input 

    $statment= mysqli_prepare($con,"INSERT INTO table5 (firstname, lastname, email) VALUES (?, ?, ?) ");

    /// because the values are not really inserted we neet to bind them 
    mysqli_stmt_bind_param($statment,'sss',$firstname, $lastname,$email);
    //the seconde parametre is used to specify the tyoe of input, in our exaple we use string,string,string


    //no lets insert some data
    $firstname='taqiyeddine';
    $lastname='djouani';
    $email="djouani.tqiyeddine@gmail.com";

    //we can perform the email check using filter var 

    if (filter_var($email,FILTER_VALIDATE_EMAIL)){
        if (mysqli_stmt_execute($statment)){
            echo "insrted to the table succefully !";
        }
        else {
            echo "error inserting the data...".$mysqli_stmt_error($statment);
        }
    }
// close the statement and the connection
mysqli_stmt_close($statment);
mysqli_close($con);
?>
