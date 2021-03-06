<?php
/**
 * @version		$Id: category_item.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);

?>
<!---------------------------------Whats new------------------------------------------------------------------------------------>
<?php if ($this->category->alias == 'whats-new'): ?>
<div class="main_li">
    <div class="news">
        <?php if($this->item->params->get('catItemDateCreated')): ?>
        <!-- Date created -->
        <span class="latestItemDateCreated">
                    <?php echo JHTML::_('date', $this->item->created , 'j.m.Y'); ?>
                </span>
        <?php endif; ?>
        <span class="img_icon">&nbsp;</span>
    </div><!--news-->

    <?php if($this->item->params->get('itemImage') && !empty($this->item->image)): ?>
    <!-- Item Image -->
    <div class="latestItemImageBlock">
        <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
            <img src="<?php echo $this->item->imageSmall; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:100%;" />
        </a>

    </div>
    <?php endif; ?>
    <!--        <pre>-->
    <!--            --><?php //print_r($this->item); die();?>
    <!--        </pre>-->
    <div class="latestItemBody">
        <?php if($this->item->params->get('catItemTitle')): ?>
        <!-- Item title -->
        <h3 class="latestItemTitle">
            <?php if ($this->item->params->get('catItemTitleLinked')): ?>
            <a href="<?php echo $this->item->link; ?>">
                <?php echo $this->item->title; ?>
            </a>
            <?php else: ?>
            <?php echo $this->item->title; ?>
            <?php endif; ?>
        </h3>
        <?php endif; ?>
        <!-- Plugins: AfterDisplayTitle -->
        <?php echo $this->item->event->AfterDisplayTitle; ?>

        <!-- K2 Plugins: K2AfterDisplayTitle -->
        <?php echo $this->item->event->K2AfterDisplayTitle; ?>

        <?php if($this->item->params->get('catItemIntroText')): ?>
        <!-- Item introtext -->
        <div class="latestItemIntroText">
            <?php echo $this->item->introtext; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Plugins: BeforeDisplayContent -->
    <?php echo $this->item->event->BeforeDisplayContent; ?>

    <!-- K2 Plugins: K2BeforeDisplayContent -->
    <?php echo $this->item->event->K2BeforeDisplayContent; ?>

    <!-- Plugins: AfterDisplayContent -->
    <?php echo $this->item->event->AfterDisplayContent; ?>

    <!-- K2 Plugins: K2AfterDisplayContent -->
    <?php echo $this->item->event->K2AfterDisplayContent; ?>


    <?php if($this->item->params->get('catItemCategory') || $this->item->params->get('catItemTags')): ?>
    <div class="latestItemLinks">

        <?php if($this->item->params->get('catItemCategory')): ?>
        <!-- Item category name -->
        <div class="latestItemCategory">
            <span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
            <a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<span class="video_arrow"><a class="video_link_arrow" href="<?php echo $this->item->link; ?>">&nbsp;</a></span>


<!------------------------------------Video short---------------------------------------------------------------------------------->
<?php elseif ($this->category->alias == 'video' && $this->view_mode == 'short'): ?>
<div class="short_view">
    <?php if($this->item->params->get('catItemDateCreated')): ?>
    <!-- DATE CREATED -->
    <span class="catItemDateCreated">
			<?php echo JHTML::_('date', $this->item->created , 'j.m.Y'); ?>
		</span>
    <?php endif; ?>

    <?php if($this->item->params->get('catItemTitle')): ?>
    <!-- ITEM TITLE -->
    <h3 class="catItemTitle">
        <?php if(isset($this->item->editLink)): ?>
        <!-- Item edit link -->
        <span class="catItemEditLink">
                    <a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
                        <?php echo JText::_('K2_EDIT_ITEM'); ?>
                    </a>
            </span>
        <?php endif; ?>

        <?php if ($this->item->params->get('catItemTitleLinked')): ?>
        <a href="<?php echo $this->item->link; ?>">
            <?php echo $this->item->title; ?>
        </a>
        <?php else: ?>
        <?php echo $this->item->title; ?>
        <?php endif; ?>

        <?php if($this->item->params->get('catItemFeaturedNotice') && $this->item->featured): ?>
        <!-- FEATURED FLAG -->
        <span>
                    <sup>
                        <?php echo JText::_('K2_FEATURED'); ?>
                    </sup>
            </span>
        <?php endif; ?>
    </h3>
    <?php endif; ?>
</div>


<!--------------------------------------Video full-------------------------------------------------------------------------->

<?php else: ?>

<!-- Start K2 Item Layout -->
<?php //echo ($this->item->featured) ? 'catItemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>

<!-- Plugins: BeforeDisplay -->
<?php //echo $this->item->event->BeforeDisplay; ?>

<!-- K2 Plugins: K2BeforeDisplay -->
<?php //echo $this->item->event->K2BeforeDisplay; ?>

<div class="catItemHeader">
    <div class="category_custom_video">
        <img src="<?php if ($this->item->imageSmall):?><?php echo $this->item->imageSmall; ?><?php else: ?>/images/logo_video_preview.jpg<?php endif; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:100%;" />
        <a class="category_custom_link" href="<?php echo $this->item->link; ?>">&nbsp;</a>
    </div>

    <!--        --><?php //if($this->item->params->get('catItemVideo') && !empty($this->item->video)): ?>
    <!--        <!-- ITEM VIDEO -->
    <!--            --><?php //if($this->item->videoType=='embedded'): ?>
    <!--            <div class="catItemVideoEmbedded">-->
    <!--                --><?php //echo $this->item->video; ?>
    <!--            </div>-->
    <!--            --><?php //else: ?>
    <!--            <span class="catItemVideo">--><?php //echo $this->item->video; ?><!--</span>-->
    <!--            --><?php //endif; ?>
    <!--        --><?php //endif; ?>
    <!--    <a class="video_link" href="--><?php //echo $this->item->link; ?><!--">&nbsp;</a>-->


</div>
    <div class="catItemBody">
    <!-- Plugins: BeforeDisplayContent -->
<!--    --><?php //echo $this->item->event->BeforeDisplayContent; ?>
<!-- K2 Plugins: K2BeforeDisplayContent -->
<!--    --><?php //echo $this->item->event->K2BeforeDisplayContent; ?>
<!---->
<!--    Priches Series-->
    <?php if (count($this->item->extra_fields)>0 && $this->item->extra_fields[0]->value != ''): ?>
        <h3><?php echo $this->item->extra_fields[0]->value ?></h3>
    <?php endif; ?>
    <?php if($this->item->params->get('catItemTitle')): ?>
    <!-- ITEM TITLE -->
    <h2 class="catItemTitle">
        <?php if(isset($this->item->editLink)): ?>
        <!-- Item edit link -->
        <span class="catItemEditLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
                    <?php echo JText::_('K2_EDIT_ITEM'); ?>
                </a>
			</span>
        <?php endif; ?>

        <?php if ($this->item->params->get('catItemTitleLinked')): ?>
        <a href="<?php echo $this->item->link; ?>">
            <?php echo $this->item->title; ?>
        </a>
        <?php else: ?>
        <?php echo $this->item->title; ?>
        <?php endif; ?>

        <?php if($this->item->params->get('catItemFeaturedNotice') && $this->item->featured): ?>
        <!-- FEATURED FLAG -->
        <span>
                <sup>
                    <?php echo JText::_('K2_FEATURED'); ?>
                </sup>
	  	    </span>
        <?php endif; ?>
    </h2>
        <?php endif; ?>
<!-- Plugins: AfterDisplayTitle -->
    <?php echo $this->item->event->AfterDisplayTitle; ?>
<!-- K2 Plugins: K2AfterDisplayTitle -->
    <?php echo $this->item->event->K2AfterDisplayTitle; ?>

    <?php if($this->item->params->get('catItemDateCreated')): ?>
    <!-- DATE CREATED -->
    <span class="catItemDateCreated">
			<?php echo JHTML::_('date', $this->item->created , 'j.m.Y'); ?>
		</span>
        <?php endif; ?>
    <?php if($this->item->params->get('catItemDateModified')): ?>
    <!-- ITEM DATE MODIFIED -->
        <?php if($this->item->modified != $this->nullDate && $this->item->modified != $this->item->created ): ?>
        <span class="catItemDateModified">
		    <?php echo JText::_('K2_LAST_MODIFIED_ON'); ?> <?php echo JHTML::_('date', $this->item->modified, JText::_('K2_DATE_FORMAT_LC2')); ?>
	    </span>
            <?php endif; ?>
        <?php endif; ?>
    <?php if($this->item->params->get('catItemAuthor')): ?>
    <!-- ITEM AUTHOR -->
    <span class="catItemAuthor">
			<?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?>
        <?php if(isset($this->item->author->link) && $this->item->author->link): ?>
        <a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
        <?php else: ?>
        <?php echo $this->item->author->name; ?>
        <?php endif; ?>
		</span>
        <?php endif; ?>
    <?php if($this->item->params->get('catItemIntroText')): ?>
    <!-- ITEM INTROTEXT -->
    <div class="catItemIntroText">
        <?php echo $this->item->introtext; ?>
    </div>
        <?php endif; ?>
<!-- Plugins: AfterDisplayContent -->
    <?php echo $this->item->event->AfterDisplayContent; ?>

<!-- K2 Plugins: K2AfterDisplayContent -->
    <?php echo $this->item->event->K2AfterDisplayContent; ?>
    <?php if($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>
    <!-- Item Image -->
    <div class="catItemImageBlock">
		  <span class="catItemImage">
		    <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
                <img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php //echo $this->item->imageWidth; ?>-px; height:auto;" />
            </a>
		  </span>
    </div>
        <?php endif; ?>
    <?php if($this->item->params->get('catItemRating')): ?>
    <!-- Item Rating -->
    <div class="catItemRatingBlock">
        <span><?php echo JText::_('K2_RATE_THIS_ITEM'); ?></span>
        <div class="itemRatingForm">
            <ul class="itemRatingList">
                <li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
                <li><a href="#" rel="<?php echo $this->item->id; ?> " title="<?php echo JText::_('K2_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
                <li><a href="#" rel="<?php echo $this->item->id; ?> " title="<?php echo JText::_('K2_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
                <li><a href="#" rel="<?php echo $this->item->id; ?> " title="<?php echo JText::_('K2_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
                <li><a href="#" rel="<?php echo $this->item->id; ?> " title="<?php echo JText::_('K2_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
                <li><a href="#" rel="<?php echo $this->item->id; ?> " title="<?php echo JText::_('K2_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
            </ul>
            <div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"><?php echo $this->item->numOfvotes; ?></div>
        </div>
    </div>
        <?php endif; ?>
    <?php if(
        $this->item->params->get('catItemHits') ||
        $this->item->params->get('catItemCategory') ||
        $this->item->params->get('catItemTags') ||
        $this->item->params->get('catItemAttachments')) ?>
        <?php if($this->item->params->get('catItemHits')): ?>
    <!-- Item Hits -->
    <div class="catItemHitsBlock">
			<span class="catItemHits">
				<?php echo JText::_('K2_READ'); ?> <b><?php echo $this->item->hits; ?></b> <?php echo JText::_('K2_TIMES'); ?>
			</span>
    </div>
        <?php endif; ?>
    <?php if($this->item->params->get('catItemCategory')): ?>
    <!-- Item category name -->
    <div class="catItemCategory">
        <span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
        <a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
    </div>
        <?php endif; ?>
    <?php if($this->item->params->get('catItemTags') && count($this->item->tags)): ?>
    <!-- Item tags -->
    <div class="catItemTagsBlock">
        <span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
        <ul class="catItemTags">
            <?php foreach ($this->item->tags as $tag): ?>
            <li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
        <?php endif; ?>

    <?php if($this->item->params->get('catItemAttachments') && count($this->item->attachments)): ?>
    <!-- Item attachments -->
    <div class="catItemAttachmentsBlock">
        <span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
        <ul class="catItemAttachments">
            <?php foreach ($this->item->attachments as $attachment): ?>
            <li>
                <a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>">
                    <?php echo $attachment->title ; ?>
                </a>
                <?php if($this->item->params->get('catItemAttachmentsCounter')): ?>
                <span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
        <?php endif; ?>

    <?php if($this->item->params->get('catItemImageGallery') && !empty($this->item->gallery)): ?>
    <!-- Item image gallery -->
    <div class="catItemImageGallery">
        <h4><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h4>
        <?php echo $this->item->gallery; ?>
    </div>
        <?php endif; ?>
    <?php if($this->item->params->get('catItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
    <!-- Anchor link to comments below -->
        <div class="catItemCommentsLink">
            <?php if(!empty($this->item->event->K2CommentsCounter)): ?>
            <!-- K2 Plugins: K2CommentsCounter -->
            <?php echo $this->item->event->K2CommentsCounter; ?>
            <?php else: ?>
            <?php if($this->item->numOfComments > 0): ?>
                <a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
                    <?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
                </a>
                <?php else: ?>
                <a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
                    <?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
                </a>
                <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($this->item->params->get('catItemReadMore')): ?>
        <!-- Item "read more..." link -->
        <div class="catItemReadMore">
            <a class="k2ReadMore" href="<?php echo $this->item->link; ?>">
                <?php echo JText::_('K2_READ_MORE'); ?>
            </a>
        </div>
            <?php endif; ?>
    <!------------------------------------------------------------------------------------------------------------->
    </div>
    <?php endif; ?>
<!-- Plugins: AfterDisplay -->
<?php echo $this->item->event->AfterDisplay; ?>

<!-- K2 Plugins: K2AfterDisplay -->
<?php echo $this->item->event->K2AfterDisplay; ?>
<!-- End K2 Item Layout -->
<?php endif; ?>