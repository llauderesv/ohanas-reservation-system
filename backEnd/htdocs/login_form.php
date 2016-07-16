<body onload="modal()">
	<div class="container" id="load">
	<div class="modal fade" id="modal_login">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header" style="background-color: rgb(0,164,156);">
					<button style="color: rgb(0,0,0);" type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title" style="color: rgb(255,255,255); font-weight:bold;">Login your account</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<h4 style="font-weight:bold; color: rgb(182,0,97);"><?php if(isset($error)) print $error;?></h4>
					</div>	
					<form action="login.php" method="post" role="form" data-toggle="validator">
						<div class="form-group">	
								<input type="text" name="username" class="form-control" maxlength="35" id="inputUser" placeholder="Username" data-error="Your username is empty" required />
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<input type="password" name="pass" class="form-control" maxlength="35" id="inputPass" placeholder="Password" data-error="Your password is empty" required /></p>
						<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<input type="submit" id="btnSign" name="submit" value="Sign In" class="btn btn-block" />
						</div>
					</form>	
				</div>
				
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	function modal() {
		$('#modal_login').modal('show');
	}
</script>