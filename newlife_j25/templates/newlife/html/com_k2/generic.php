<?php
/**
 * @version		$Id: generic.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

/**
 * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
 *
 * @param string $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 *
 * @return string Trimmed string.
 */
function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                    // if tag is a closing tag
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if($considerHtml) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}


$plugin = JPluginHelper::getPlugin( 'content', 'jw_allvideos' );

?>



<!-- Start K2 Generic (search/date) Layout -->
<div id="k2Container" class="genericView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">



	<?php if(count($this->items)): ?>
	<ul class="genericItemList">
		<?php foreach($this->items as $item): ?>
        <?php if ($this->view_mode == 'short'): ?>
               <li class="video_list_short">
                    <div class="short_view">
                        <?php if($this->params->get('genericItemDateCreated')): ?>
                        <!-- Date created -->
                        <span class="genericItemDateCreated">
                            <?php echo JHTML::_('date', $item->created , 'j.m.Y'); ?>
                        </span>
                        <?php endif; ?>
                        <?php if($this->params->get('genericItemTitle')): ?>
                        <!-- Item title -->
                        <h3 class="genericItemTitle">
                            <?php if ($this->params->get('genericItemTitleLinked')): ?>
                            <a href="<?php echo $item->link; ?>">
                                <?php echo $item->title; ?>
                            </a>
                            <?php else: ?>
                            <?php echo $item->title; ?>
                            <?php endif; ?>
                        </h3>
                        <?php endif; ?>
                    </div>
                </li>
            <?php else: ?>
		<!-- Start K2 Item Layout -->
		<li class="genericItemView">


			<div class="genericItemHeader">
                <div class="category_custom_video">
                    <img src="<?php if ($item->imageSmall):?><?php echo $item->imageSmall; ?><?php else: ?>/images/video_preview.jpg<?php endif; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width:<?php echo $item->imageWidth; ?>px;height:100%;" />
                    <a class="category_custom_link" href="<?php echo $item->link; ?>">&nbsp;</a>
                </div>
<!--                <!-- Plugins: BeforeDisplayContent -->
<!--                --><?php //echo $this->item->event->BeforeDisplayContent; ?>
<!--                <!-- K2 Plugins: K2BeforeDisplayContent -->
<!--                --><?php //echo $this->item->event->K2BeforeDisplayContent; ?>
<!--                --><?php //if(!empty($item->video)): ?>
              <!-- ITEM VIDEO -->
<!--                    --><?php //if($item->videoType=='embedded'): ?>
<!--                    <div class="catItemVideoEmbedded">-->
<!--                        --><?php //echo $item->video; ?>
<!--                    </div>-->
<!--                    --><?php //else: ?>
<!--                    <span class="catItemVideo">--><?php //echo $item->video; ?><!--</span>-->
<!--                    --><?php //endif; ?>
<!--                --><?php //endif; ?>
<!--                <a class="video_link" href="--><?php //echo $item->link; ?><!--">&nbsp;</a>-->

		  </div>

		  <div class="genericItemBody">
              <?php if($this->params->get('genericItemExtraFields') && count($item->extra_fields)): ?>
              <!-- Item extra fields -->

              <ul class="genericItemExtraFields">
                      <?php foreach ($item->extra_fields as $key=>$extraField): ?>
                      <?php if($extraField->value != ''): ?>
                          <li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
                              <?php if($extraField->type == 'header'): ?>
                              <h4 class="genericItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
                              <?php else: ?>

                              <span class="genericItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
                              <?php endif; ?>
                          </li>
                          <?php endif; ?>
                      <?php endforeach; ?>
              </ul>


              <?php endif; ?>
              <?php if($this->params->get('genericItemTitle')): ?>
              <!-- Item title -->
              <h2 class="genericItemTitle">
                  <?php if ($this->params->get('genericItemTitleLinked')): ?>
                  <a href="<?php echo $item->link; ?>">
                      <?php echo $item->title; ?>
                  </a>
                  <?php else: ?>
                  <?php echo $item->title; ?>
                  <?php endif; ?>
              </h2>
              <?php endif; ?>
              <?php if($this->params->get('genericItemDateCreated')): ?>
              <!-- Date created -->
              <span class="genericItemDateCreated">
					<?php echo JHTML::_('date', $item->created , 'j.m.Y'); ?>
				</span>
              <?php endif; ?>


			  <?php if($this->params->get('genericItemImage') && !empty($item->imageGeneric)): ?>
			  <!-- Item Image -->
			  <div class="genericItemImageBlock">
				  <span class="genericItemImage">
				    <a href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
				    	<img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width:<?php echo $this->params->get('itemImageGeneric'); ?>px; height:auto;" />
				    </a>
				  </span>
				   
			  </div>
			  <?php endif; ?>
			  
			  <?php if($this->params->get('genericItemIntroText')): ?>
			  <!-- Item introtext -->
			  <div class="genericItemIntroText">
			  	<?php echo truncateHtml($item->introtext) ?>
			  </div>
			  <?php endif; ?>
		  </div>
		</li>
		<!-- End K2 Item Layout -->
        <?php endif; ?>
		
		<?php endforeach; ?>
	</ul>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
	
	<?php else: ?>
	<p><?php echo JText::_('K2_SORRY_NO_RESULTS_WERE_FOUND'); ?></p>
	<?php endif; ?>
	
</div>
<!-- End K2 Generic (search/date) Layout -->