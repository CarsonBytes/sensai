<?php defined('_JEXEC') or die; ?>
<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
	<?php foreach($this->items as $item): ?>
	<url>
		<loc><?php echo $item->url; ?></loc>
		<news:news>
			<news:publication>
				<news:name><?php echo $this->escape($this->siteName); ?></news:name>
				<news:language><?php echo $this->escape($this->language); ?></news:language>
			</news:publication>
			<news:publication_date><?php echo $this->escape($item->publicationDate); ?></news:publication_date>
			<news:title><?php echo $this->escape($item->title); ?></news:title>
			<news:keywords><?php echo $this->escape($item->categoryTitle); ?></news:keywords>
		</news:news>
	</url>
	<?php endforeach; ?>
</urlset>
