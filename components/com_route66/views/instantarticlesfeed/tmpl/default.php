<?php defined('_JEXEC') or die; ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
	<channel>
		<title><?php echo htmlspecialchars($this->feed->siteName, ENT_COMPAT, 'UTF-8'); ?></title>
		<link><?php echo $this->feed->siteLink; ?></link>
		<description><?php echo htmlspecialchars($this->feed->siteDescription, ENT_COMPAT, 'UTF-8'); ?></description>
		<language><?php echo $this->feed->siteLanguage; ?></language>
		<lastBuildDate><?php echo htmlspecialchars($this->feed->lastBuildDate, ENT_COMPAT, 'UTF-8'); ?></lastBuildDate>
		<?php foreach ($this->feed->items as $item): ?>
			<item>
				<title><?php echo htmlspecialchars($item->title); ?></title>
				<link><?php echo $item->url; ?></link>
				<guid><?php echo $item->guid; ?></guid>
				<pubDate><?php echo htmlspecialchars($item->publicationDate, ENT_COMPAT, 'UTF-8'); ?></pubDate>
				<content:encoded><![CDATA[<?php $this->item = $item; echo $this->loadTemplate('item'); ?>]]></content:encoded>
			</item>
		<?php endforeach; ?>
	</channel>
</rss>
