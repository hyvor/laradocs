<nav>
	<div class="container">
		<a class="nav-brand" href="<?= config('docgenpackage.main_link') ?>">
			<img src="<?= config('docgenpackage.logo_url') ?>" alt="Hyvor Blogs LOGO" width="30" height="30" />
			<span class="brand-name"><?= config('docgenpackage.brand_name') ?></span>
		</a>

		<div class="navbar-content">
	
		</div>
	</div>

	<script>
		function toggleNavBar(e) {
			var navbar = document.querySelector('.navbar-nav');
			e && e.stopPropagation();
			if (navbar.classList.contains('open')) {
				navbar.classList.remove('open');
				window.removeEventListener('click', handleNavBarOut);
			} else {
				navbar.classList.add('open')
				window.addEventListener('click', handleNavBarOut)
			}
		}
		function handleNavBarOut(e) {
			if (!document.querySelector('.navbar-nav').contains(e.target)) {
				toggleNavBar();
			}
		}
	</script>

</nav>