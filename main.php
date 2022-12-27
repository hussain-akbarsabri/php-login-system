<?php 
include "action.php";

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Records</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="">
					<br>
					<!-- 
					<div class="brand">
						<img src="img/logo.jpg" alt="logo">
					</div>
					-->
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Records</h4>
							<table class="table table-striped" style="text-align: center;">
								<thead>
									<tr>
										<th style="text-align: center;">Name</th>
						                <th style="text-align: center;">Email</th>
						                <th style="text-align: center;">Password</th>
						                <th style="text-align: center;">Edit</th>
						                <th style="text-align: center;">Delete</th>
						            </tr>
			          			</thead>
			          			<tbody>
			          				<?php 
			          				$myrow = $obj->fetch_record("users");
			              			foreach ($myrow as $row) 
			              			{
			                		?>
			                  		<tr>
			                    		<td><?php echo $row["name"]; ?></td>
			                    		<td><?php echo $row["email"]; ?></td>
			                    		<td><?php echo $row["password"]; ?></td>
			                    		<td><a href="register.php?update=1&id=<?php echo $row["ind"]; ?>" class="btn btn-info">Edit</a></td>
			                    		<td><a href="action.php?delete=1&id=<?php echo $row["ind"]; ?>" class="btn btn-danger">Delete</a></td>
			                  		</tr>
			                		<?php
			              			}
			            			?>
			          			</tbody>
			        		</table>
						</div>
					</div>
					<!--
					<div class="footer">
						Copyright &copy; 2017 &mdash; Your Company 
					</div>
					-->
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>