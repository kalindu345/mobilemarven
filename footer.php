<footer class="footer-body">
	<div class="main-content">
		<div class="left box">
			<h2>About us</h2>
			<div class="content">
				<p>Discover the best in quality products at Mobile marven's e-commerce app. Explore a wide range of phones. Stay updated with the latest trends and be part of our community. MobileMarven - your destination for chic and trendy style. </p>
				<div class="social">
					<span style="font-size:22px;margin-left:10px;"><i class="bi bi-facebook"></i></span>
					<span style="font-size:22px;margin-left:10px;"><i class="bi bi-twitter"></i></span>
					<span style="font-size:22px;margin-left:10px;"><i class="bi bi-instagram"></i></span>
					<span style="font-size:22px;margin-left:10px;"><i class="bi bi-youtube"></i></span>
					<span style="font-size:22px;margin-left:10px;"><i class="bi bi-google"></i></span>

				</div>
			</div>
		</div>

		<div class="center box">
			<h2>Address</h2>
			<div class="content">
				<div class="place">
					<span><i class="bi bi-house-fill"></i><span>
							<span class="text">Kollupitiya,Colombo 03,SriLanka</span>
				</div>

				<div class="phone">
					<span><i class="bi bi-telephone-fill"></i></span>
					<span class="text">+94117 367 789</span>
				</div>
				<div class="email">
					<span><i class="bi bi-envelope-fill"></i></span>
					<span class="text">mobilemaven@gmail.com</span>
				</div>


			</div>
		</div>

		<div class="right box">
			<h2>Contact us</h2>
			<div class="content">
				<form action="#">
					<div class="email">
						<div class="text">Email *</div>
						<input id="user_email" type="email" required value="<?php echo $_SESSION["u"]["email"] ?>">
					</div>
					<div class="msg">
						<div class="text">Message *</div>
						<textarea rows="2" cols="25" required id="msg_web"></textarea>
					</div>
					<div class="button1">
						<button onclick="sendAdmin();">Send</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="bottom" style="text-align:center;">

		<span class="credit">Created By <span class="text-warning">MobileMarven<span> | </span>
				<span class="far fa-copyright"></span><span> &copy; 2024 All rights reserved.</span>

	</div>
</footer>