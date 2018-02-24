<?php
	// Start the session
	session_start();
	?>
<!DOCTYPE html>
<html>
	<head>
		<title>Business Dashboard</title>
		<!-- For-Mobile-Apps -->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!-- //For-Mobile-Apps -->
		<!-- Style -->
		<link rel="stylesheet" href="css/user-dashboard.css" type="text/css" media="all" />
		<link href="css/font-awesome.css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/user-dashboard.js"></script>
		<!-- Web-Fonts -->
		<link href='//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
		<!-- //Web-Fonts -->
		<?php 
			include 'business_nav.html';
			require '../config.php';
			$businessid = $_GET["businessid"];
			
			if (isset($_POST['businessname'])) {
                $businessname = $_POST['businessname'];
            }
            if (isset($_POST['businesssector'])) {
                $businesssector = $_POST['businesssector'];
            }
            if (isset($_POST['address1'])) {
                $address1 = $_POST['address1'];
            }
            if (isset($_POST['address2'])) {
                $address2 = $_POST['address2'];
            }
            if (isset($_POST['city'])) {
                $city = $_POST['city'];
            }
            if (isset($_POST['state'])) {
                $state = $_POST['state'];
            }
            if (isset($_POST['country'])) {
                $country = $_POST['country'];
            }
            if (isset($_POST['zipcode'])) {
                $zipcode = $_POST['zipcode'];
            }
			if (isset($_POST['cancel'])) {
				$cancel = $_POST['cancel'];
			}
			if (isset($_POST['delete'])) {
				$delete = $_POST['delete'];
			}
			if(!empty($delete)) {
				$query = "UPDATE businessdetail
						 SET isactive=0 
						 WHERE id=".$businessid;
				print $query;
				$result = $mysqli->query($query);
	            if ($result) {
	                echo '<script>window.location.href = "business.php#horizontalTab3";</script>';
	            } else {
	                echo "Failed to delete profile";
	            }
			} else if(!empty($cancel)) {
				echo '<script>window.location.href = "business.php#horizontalTab3";</script>';
			} else if(!empty($businessname)) {
				$query = "UPDATE businessdetail
						 SET businessname=\"".$businessname."\", businesssector=\"".$businesssector."\", address1=\"".$address1."\", city=\"".$city."\", state=\"".$state."\", zipcode=\"".$zipcode."\", modified=sysdate() 
						 WHERE id=".$businessid;
				
                $result = $mysqli->query($query);
                if ($result) {
                    echo '<script>window.location.href = "business.php#horizontalTab3";</script>';
                } else {
                    echo "Failed to update profile";
                }
			} else if(!empty($businessid)) {
				$query = "SELECT businessname, businesssector, address1, address2, city, state, country, zipcode
						  FROM businessdetail
						  WHERE id=".$businessid;
				$result = $mysqli->query($query);
				$businessresultset = array();
				if ($result->num_rows > 0) {
					$row = $result->fetch_array();
					array_push($businessresultset, $row["businessname"]);
					array_push($businessresultset, $row["businesssector"]);
					array_push($businessresultset, $row["address1"]);
					array_push($businessresultset, $row["address2"]);
					array_push($businessresultset, $row["city"]);
					array_push($businessresultset, $row["state"]);
					array_push($businessresultset, $row["country"]);
					array_push($businessresultset, $row["zipcode"]);
				}
			}
			?>
	</head>
	<body>
		<h1></h1>
		<div class="container">
			<div class="tab">
				<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
					<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
					<script type="text/javascript">
						$(document).ready(function () {
							$('#horizontalTab').easyResponsiveTabs({
								type: 'default', //Types: default, vertical, accordion
								width: 'auto', //auto or any width like 600px
								fit: true,   // 100% fit in a container
								closed: 'accordion', // Start closed if in accordion view
								activate: function(event) { // Callback function if tab is switched
									var $tab = $(this);
									var $info = $('#tabInfo');
									var $name = $('span', $info);
									$name.text($tab.text());
									$info.show();
								}
							});
						
							$('#verticalTab').easyResponsiveTabs({
								type: 'vertical',
								width: 'auto',
								fit: true
							});
						});
						
						
						
						function editOffer(){
							alert('hi');
						}
						
						
					</script>
					<div class="tabs">
						<div class="tab-left">
							<ul class="resp-tabs-list" style="margin: 0px;">
								<li class="resp-tab-item-edit" onclick="loadScan();"><i class="fa fa-car" aria-hidden="true"></i>Edit</li>
								<li class="resp-tab-item-edit"><i class="fa fa-university" aria-hidden="true"></i>Delete</li>
							</ul>
						</div>
						<div class="tab-right">
							<div class="resp-tabs-container">
								<!-- Edit Business section -->
								<div class="tab-1 resp-tab-content">
									<p class="secHead">Edit Your Business</p>
									<div class="register agileits">
										<form method="post" class="agile_form">
											<input type="text" placeholder="Business Name" name="businessname" class="name agileits" required="" 
												value="<?php echo !isset($businessresultset[0]) ? '' : $businessresultset[0] ?>" readonly />
											<input type="text" placeholder="Business Sector" name="businesssector" class="name agileits" required=""
												value="<?php echo !isset($businessresultset[1]) ? '' : $businessresultset[1] ?>" readonly />
											<input type="text" placeholder="Address : Street 1" name="address1" class="name agileits" required=""
												value="<?php echo !isset($businessresultset[2]) ? '' : $businessresultset[2] ?>" />
											<input type="text" placeholder="Address : Street 2" name="address2" class="name agileits" required=""
												value="<?php echo !isset($businessresultset[3]) ? '' : $businessresultset[3] ?>" />
											<input type="text" placeholder="City" name="city" class="name agileits" required=""
												value="<?php echo !isset($businessresultset[4]) ? '' : $businessresultset[4] ?>" />
											<input type="text" placeholder="State" name="state" class="name agileits" required=""
												value="<?php echo !isset($businessresultset[5]) ? '' : $businessresultset[5] ?>" />
											<input type="text" placeholder="Country" name="country" class="name agileits" required=""
												value="<?php echo !isset($businessresultset[6]) ? '' : $businessresultset[6] ?>" />
											<input type="text" placeholder="Zip" name="zipcode" class="name agileits" required=""
												value="<?php echo !isset($businessresultset[7]) ? '' : $businessresultset[7] ?>" />
											<div class="submit"><br>
												<input type="submit" value="Save">
												<input name="cancel" type="submit" value="Cancel">
											</div>
										</form>
									</div>
								</div>
								<!-- Delete business -->
								<div class="tab-1 resp-tab-content">
									<p class="secHead">Delete Business</p>
									<br>
									<img class="settingImg" src="images/deactive.png" width="100" height="100">
									<div class="agile-send-mail">
										<form action="#" method="post" class="agile_form">
											<p class="b_name" style="color: white;text-align: center;">Click on below button to Delete your business.</p>
											<br>	
											<div class="submit"><br>
												<input name="delete" type="submit" value="Delete">
												<input name="cancel" type="submit" value="Cancel">
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include 'footer.php' ?>
		</div>
		<!--start-date-piker-->
		<link rel="stylesheet" href="css/jquery-ui.css" />
		<script src="js/jquery-ui.js"></script>
		<script>
			$(function() {
			$( "#datepicker,#datepicker1,#datepicker2,#datepicker3,#datepicker4,#datepicker5,#datepicker6,#datepicker7" ).datepicker();
			});
		</script>
		<!-- 97-rgba(0, 0, 0, 0.75)/End-date-piker -->	
	</body>
</html>