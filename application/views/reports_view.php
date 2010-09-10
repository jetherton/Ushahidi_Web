<?php 
/**
 * Reports view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
				<div id="main" class="clearingfix">
					<div id="mainmiddle" class="floatbox withright">
						<!-- start incident block -->
						<div class="reports">
							<div class="report-details">
								
								<h1><?php
								echo $incident_title;
								
								// If Admin is Logged In - Allow For Edit Link
								if ($logged_in)
								{
									echo " [&nbsp;<a href=\"".url::site()."admin/reports/edit/".$incident_id."\">Edit</a>&nbsp;]";
								}
								?></h1>
								
								<?php
								foreach ($incident_photos as $photo)
								{
									
									$prefix = url::base().Kohana::config('upload.relative_directory');
									echo("<img src='$prefix/$photo'/>");
									break;
								}
								?>
								<ul class="details">
									<li>
										<small>Location</small>
										<?php echo $incident_location; ?>
									</li>
									<li>
										<small>Date Last Updated</small>
										<?php echo $incident_date; ?>
									</li>
									<li>
										<small>Contact</small>
										<?php echo $person_first. " ". $person_last. "<br/>".
											$person_title. "<br/>Phone: ". $person_phone
											. '<br/>Email: <a href="mailto:'.$person_email.'">'.
											$person_email.'</a>';?>
									</li>
									<li>
										<small>Category</small>
										<?php
											foreach($incident_category as $category) 
											{ 
												echo "<a href=\"".url::site()."reports/?c=".$category->category->id."\">" .
												$category->category->category_title . "</a>&nbsp;&nbsp;&nbsp;";
											}
										?>
									</li>
									<?php
									// Action::report_meta - Add Items to the Report Meta (Location/Date/Time etc.)
									Event::run('ushahidi_action.report_meta', $incident_id);
									?>
								</ul>
							</div>
							<div class="location">
								<div class="incident-notation clearingfix">
									<ul>
										<li><img align="absmiddle" alt="Member" src="<?php echo url::base(); ?>media/img/incident-pointer.jpg"/> Member</li>
									</ul>
								</div>
								<div class="report-map">
									<div class="map-holder" id="map"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
		
				<div class="report-description">
					<h3>Member Description</h3>
						<div class="content">
							<?php echo $incident_description; ?>
						</div>
						<?php
						// Action::report_extra - Add Items to the Report Extra block
						Event::run('ushahidi_action.report_extra', $incident_id);
						
						// Filter::comments_block - The block that contains posted comments
						Event::run('ushahidi_filter.comment_block', $comments);
						echo $comments;
						?>		
					</div>
		
					<?php
					if( count($incident_photos) > 0 ) 
					{
					?>
					<!-- start images -->
					<div class="report-description">
						<h3>Images</h3>
						<div class="photos">
							<?php
							foreach ($incident_photos as $photo)
							{
								$thumb = str_replace(".","_t.",$photo);
								$prefix = url::base().Kohana::config('upload.relative_directory');
								echo("<a class='photothumb' rel='lightbox-group1' href='$prefix/$photo'><img src='$prefix/$thumb'/></a> ");
							}
							?>
						</div>
					</div>

					<!-- end images <> start side block -->
					<?php 
					} else {
					?> 

					<div class="report-description">
						<h3>Related Information</h3>
						<table cellpadding="0" cellspacing="0">
							<tr class="title">
								<th class="w-01">TITLE</th>
								<th class="w-02">SOURCE</th>
								<th class="w-03">DATE</th>
							</tr>
							<?php
								foreach ($feeds as $feed)
								{
									$feed_id = $feed->id;
									$feed_title = text::limit_chars($feed->item_title, 40, '...', True);
									$feed_link = $feed->item_link;
									$feed_date = date('M j Y', strtotime($feed->item_date));
									$feed_source = text::limit_chars($feed->feed->feed_name, 15, "...");
							?>
							<tr>
								<td class="w-01">
									<a href="<?php echo $feed_link; ?>" target="_blank">
									<?php echo $feed_title ?></a>
								</td>
								<td class="w-02"><?php echo $feed_source; ?></td>
								<td class="w-03"><?php echo $feed_date; ?></td>
							</tr>
							<?php
							}
							?>
						</table>
						<!-- end mainstream news of incident -->
					</div>
					<?php
					}?>
					
					
					
					<!--links -->
					<?php
					if( count($incident_news) > 0 ) 
					{
					?>
					<!-- start images -->
					<div class="report-description">
						<h3>Links</h3>
						<div style="margin-left: 30px; text-size: 120%;">
						
						<ul>
							<?php
							foreach ($incident_news as $news)
							{					
								echo("<li><a href='".$news."'>".$news."</a></li> ");
							}
							?>
						</ul>
						</div>
					</div>
					<?php 
					} 
					?> 
					<!-- end links -->
					
					
					


					<?php 
					if( $incident_photos <= 0) 
					{
					?> 
					<div class="small-block">
						<h3>Related Mainstream News of Incident</h3>
						<div class="block-bg">
							<table>
								<tr class="title">
									<th class="w-01">TITLE</th>
									<th class="w-02">SOURCE</th>
									<th class="w-03">DATE</th>
								</tr>
								<?php
									foreach ($feeds as $feed)
									{
										$feed_id = $feed->id;
										$feed_title = text::limit_chars($feed->item_title, 40, '...', True);
										$feed_link = $feed->item_link;
										$feed_date = date('M j Y', strtotime($feed->item_date));
										$feed_source = text::limit_chars($feed->feed->feed_name, 15, "...");
								?>
								<tr>
									<td class="w-01">
									<a href="<?php echo $feed_tdnk; ?>" target="_blank">
									<?php echo $feed_title ?></a></td>
									<td class="w-02"><?php echo $feed_source; ?></td>
									<td class="w-03"><?php echo $feed_date; ?></td>
								</tr>
								<?php
									}
								?>
							</table>
						</div>
					</div>
					<?php }	?>
					<!-- end side block -->
					
					
					<!-- start videos -->
					<?php
						if( count($incident_videos) > 0 ) 
						{
					?>
					<div class="report-description">
						<h3>Videos</h3>
						<div class="block-bg">
							<div style="overflow:auto; white-space: nowrap; padding: 10px">
								<?php
									// embed the video codes
									foreach( $incident_videos as $incident_video) {
										$videos_embed->embed($incident_video,'');
									}
								?>
							</div>
						</div>
						<?php } ?>
					</div>
					<!-- end incident block <> start other report -->
					
					<?php
					// Filter::comments_form_block - The block that contains the comments form
					Event::run('ushahidi_filter.comment_form_block', $comments_form);
					echo $comments_form;
					?>
					
				</div>
			</div>
		</div>
	</div>

