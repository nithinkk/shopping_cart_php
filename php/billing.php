<?php  session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Shoping Cart </title>
<!-- The Billing page for shopping cart -->
</head>
<body bgcolor="#000000">


<?php 
if(isset($_SESSION['cart']) )
{
	
	if(empty($_REQUEST['submit'])){
?>

<div align="center">
<h1 style="color:#FF0">Billing Info</h1>
<table style="padding:20px;" bgcolor='F6F6F6' border="0">
  <tr>
    <td>Name</td>
    <td><form id="form1" name="form1" >
      <label for="name"></label>
      <input type="text" name="name" id="name" />
    </td>
  </tr>
  <tr>
    <td>Email</td>
    <td><label for="email"></label>
    <input type="text" name="email" id="email" /></td>
  </tr>
  <tr>
    <td>Address</td>
    <td>
      <label for="address"></label>
      <textarea name="address" id="address" cols="45" rows="5"></textarea>
    </td>
  </tr>
  <tr>
    <td>Phone No</td>
    <td><label for="phone"></label>
    <input type="text" name="phone" id="phone" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" id="submit" value="Submit" /> </form></td>
  </tr>
</table>
</div>



<?php }}
else
	{
		print "<script>";
		print " self.location='product.php';";
		print "</script>";
	}
?>


<?php
if(!empty($_REQUEST['submit']))
{
 		$cname=$_REQUEST['name'];
		$email=$_REQUEST['email'];
		$address=$_REQUEST['address'];
		$phone=$_REQUEST['phone'];
		include("common/db.php");
		
		$result=mysql_query("insert into customers values('','$cname','$email','$address','$phone')");
		$customerid=mysql_insert_id();
		$date=date('Y-m-d');
		$result=mysql_query("insert into orders values('','$date','$customerid')");
		$orderid=mysql_insert_id();
		
		
		
		$total=0;
		foreach($_SESSION['cart'] as $id => $x)
			{
			include("common/db.php");
			$result=mysql_query("select serial,name,price from products WHERE serial=$id");
			$myrow=mysql_fetch_array($result);
			$name=$myrow['name'];
			$price=$myrow['price'];
			$line_cost=$price*$x;
			$total= $total+$line_cost;
			mysql_query("insert into order_detail values ($orderid,$id,$x,$price)");
			
			

}
		
	echo"<span style='color:#fff'>Thank you ".$cname." for placing an order</div>";
	unset($_SESSION['cart']);
		
}
?>
</body>
</html>