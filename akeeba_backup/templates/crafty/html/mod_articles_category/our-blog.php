
<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$moduleIntro = $params->get ('module-intro');
?>

<?php if($moduleIntro) : ?>
	<div class="module-intro col-lg-12 col-sm-12 col-xs-12"><?php echo $moduleIntro; ?></div>
<?php endif; ?>

<ul class="category-module<?php echo $moduleclass_sfx; ?>">
<?php if ($grouped) : ?>
	<?php foreach ($list as $group_name => $group) : ?>
	<li>
		<ul>
			<?php foreach ($group as $item) : ?>
				<li>
					<?php if ($params->get('link_titles') == 1) : ?>
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
						<?php echo $item->title; ?>
						</a>
					<?php else : ?>
						<?php echo $item->title; ?>
					<?php endif; ?>

					<?php if ($item->displayHits) : ?>
						<span class="mod-articles-category-hits">
						(<?php echo $item->displayHits; ?>)
						</span>
					<?php endif; ?>

					<?php if ($params->get('show_author')) :?>
						<span class="mod-articles-category-writtenby">
						<?php echo $item->displayAuthorName; ?>
						</span>
					<?php endif;?>

					<?php if ($item->displayCategoryTitle) :?>
						<span class="mod-articles-category-category">
						(<?php echo $item->displayCategoryTitle; ?>)
						</span>
					<?php endif; ?>

					<?php if ($item->displayDate) : ?>
						<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
					<?php endif; ?> 

					<?php if ($params->get('show_introtext')) :?>
						<p class="mod-articles-category-introtext">
							<?php echo $item->displayIntrotext; ?>
						</p>
					<?php endif; ?>

					<?php if ($params->get('show_readmore')) :?>
						<p class="mod-articles-category-readmore">
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
						<?php if ($item->params->get('access-view') == false) :
							echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
						elseif ($readmore = $item->alternative_readmore) :
							echo $readmore;
							echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
								if ($params->get('show_readmore_title', 0) != 0) :
									echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
									endif;
						elseif ($params->get('show_readmore_title', 0) == 0) :
							echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
						else :
							echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
							echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
						endif; ?>
						</a>
						</p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</li>
	<?php endforeach; ?>
<?php else : ?>
	<?php foreach ($list as $item) : ?>
		<li class="tp-blog col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeInUp animated animated" data-wow-delay=".5s">
			<div class="article-img col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<?php  
			//Get images 
			$images = "";
			if (isset($item->images)) {
				$images = json_decode($item->images);
			}
			$imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));
			
			if ($imgexists) {			
			$images->image_intro = $images->image_intro?$images->image_intro:$images->image_fulltext;
			$images->image_intro_caption = $images->image_intro_caption?$images->image_intro_caption:$images->image_fulltext_caption;
			$images->image_intro_alt = $images->image_intro_alt?$images->image_intro_alt:$images->image_fulltext_alt;
			?>
			
				<div class="img-intro blog-intro">
					<a class="mod-articles-img <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
					<img class="img-responsive"
						<?php if ($images->image_intro_caption):
							echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
						endif; ?>
						src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
					
					</a>
					
				</div>
				
				
			<?php }else{ ?>
				<div class="blog-intro">
					<img class="img-responsive" src="<?php echo JURI::root(true);?>/images/themeparrot/demo/default.jpg" alt="Default Image"/>
				</div>
			<?php } ?>
			
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mod-content">
			<?php if ($params->get('link_titles') == 1) : ?>
				<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
				<h3><?php echo $item->title; ?></h3>
				</a>
			<?php else : ?>
				<h3><?php echo $item->title; ?></h3>
			<?php endif; ?>

			<?php if ($item->displayHits) :?>
				<span class="mod-articles-category-hits">
				(<?php echo $item->displayHits; ?>)  </span>
			<?php endif; ?>

			<?php if ($params->get('show_author')) :?>
				<span class="mod-articles-category-writtenby">
					<?php echo $item->displayAuthorName; ?>
				</span>
			<?php endif;?>

			<?php if ($item->displayCategoryTitle) :?>
				<span class="mod-articles-category-category">
				(<?php echo $item->displayCategoryTitle; ?>)
				</span>
			<?php endif; ?>

			<?php if ($item->displayDate) : ?>
				<span class="mod-articles-category-date">
					<?php echo $item->displayDate; ?>
				</span>
			<?php endif; ?>

			<?php if ($params->get('show_introtext')) :?>
				<p class="mod-articles-category-introtext">
				<?php echo $item->displayIntrotext; ?>
				</p>
			<?php endif; ?>

			<?php if ($params->get('show_readmore')) :?>
				<p class="mod-articles-category-readmore">
				<a class="mod-articles-category-title-readmore btn btn-primary btn-rounded  btn-border <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
					<?php if ($item->params->get('access-view') == false) :
						echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
					elseif ($readmore = $item->alternative_readmore) :
						echo $readmore;
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
					else :
						echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
						//echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
					endif; ?>
				</a>
				</p>
			<?php endif; ?>
			</div>
		</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>

