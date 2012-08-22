<?php  session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shoping Cart </title>
</head>
<body bgcolor="#000000">
<h3 style="background-color:#FF0"align="center"> Shopping Cart</h3>

<?php 
if (isset($_GET['id']))
	$id=$_GET['id'];
 else
 	$id=1;
	
if (isset($_GET['action']))
	$action=$_GET['action'];
 else
 	$action="empty";
	

switch($action){

case "add":

if($_SESSION['cart'][$id])
	$_SESSION['cart'][$id]++;
else
	$_SESSION['cart'][$id]=1;

break;	

case "remove":

if($_SESSION['cart'][$id])
{
		$_SESSION['cart'][$id]--;
		
		if($_SESSION['cart'][$id]==0)
		unset($_SESSION['cart'][$id]);
}

break;	

case "empty":
unset($_SESSION['cart']);

break;	
}

// Display cart 

if(isset($_SESSION['cart']))
{
 
echo "<p style='margin-left:380px;' ><a style='color:#FFFF00; text-decoration:none'  href='product.php?id=".$id."&action=none' >Continue shopping</a><a href='billing.php'  style='color:#fff; text-decoration:none;margin-left:310px;' ><b>Place Order</b></a></p><table  style='padding:10px;'  align='center' border='0' bgcolor='F6F6F6' cellpadding='0' width='600'>";
$total=0;
foreach($_SESSION['cart'] as $id => $x)
{
include("common/db.php");
$result=mysql_query("select name,price from products WHERE serial=$id");
$myrow=mysql_fetch_array($result);
$name=$myrow['name'];
$price=$myrow['price'];
$line_cost=$price*$x;
$total= $total+$line_cost;

	echo "<tr bgcolor='#f0f0f0'>";
	echo "<td align='left'>$name</td>";
	echo "<td align='right'> $x <a href='cart.php?id=".$id."&action=remove' ><img src='images/s.png'/></a> <a href='cart.php?id=".$id."&action=add' ><img src='images/a.png'/></a></td>";
	echo"<td align='right'>=$line_cost</td>";
	echo "</tr>";
} 
	echo"<tr >";
	echo "<td align='right'><br/><b> Total </b></td>";
	echo "<td align='right'><br/><b> $total </b></td>";
	echo "</tr>";
	echo "</table>";
}
else
	echo"cart is Empty";
	
?>

</body>
</html>