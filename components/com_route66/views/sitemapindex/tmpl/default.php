<?php defined('_JEXEC') or die; ?>
<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($this->items as $item): ?>
	<sitemap>
		<loc><?php echo $item; ?></loc>
	</sitemap>
	<?php endforeach; ?>
</sitemapindex>
