<?php
/**
 *  Reports view page.
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

				<div id="content">
					<div class="content-bg">
						<!-- start reports block -->
						<div class="big-block">



							<h1><?php echo "Members: "; ?> <?php echo ($category_title) ? " in $category_title" : ""?>
								<?php echo $pagination_stats; ?></h1>

							<div style="clear:both;"></div>

							<div class="report_rowtitle">
								<div class="report_col1">
									<strong><?php echo strtoupper(Kohana::lang('ui_main.media'));?></strong>
								</div>
								<div class="report_col2">
									<strong>Member</strong>
								</div>
								<div class="report_col3">
									<strong><?php echo strtoupper(Kohana::lang('ui_main.location'));?></strong>
								</div>
								<div class="report_col4">
									<strong>Contact</strong>
								</div>

							</div>
							<?php
							foreach ($incidents as $incident)
							{
								$incident_id = $incident->id;
								$incident_title = $incident->incident_title;
								$incident_description = $incident->incident_description;
								$incident_active = $incident->incident_active;


								// Trim to 150 characters without cutting words
								// XXX: Perhaps delcare 150 as constant

								$incident_description = text::limit_chars(strip_tags($incident_description), 150, "...", true);
								$incident_date = date('Y-m-d', strtotime($incident->incident_date));
								$incident_location = $locations[$incident->location_id];
								$incident_verified = $incident->incident_verified;
			
								$incident_persons = ORM::factory('Incident_Person')->where('incident_id',$incident->id)->find_all();
								$incident_person = null;
								foreach ($incident_persons as $person)
								{
									$incident_person = $person;
								}
							?>

							<div class="report_row1">

								<div class="report_thumb report_col1">
									&nbsp<?php if(isset($media_icons[$incident_id])) echo $media_icons[$incident_id]; ?>
								</div>

								<div class="report_details report_col2">
									<h3><a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>"><?php echo $incident_title; ?></a></h3>
								</div>

								<div class="report_date report_col3">
									<?php echo $incident_location; ?>
								</div>

								<div class="report_location report_col4">
									<?php 
										if(!$incident_person)
										{
											echo "No Contact Info";
										}
										else
										{
											$contact = "";
											if(!(!$incident_person->person_first || $incident_person->person_first == ""))
											{
												$contact = $incident_person->person_first;
											}
											if(!(!$incident_person->person_last || $incident_person->person_last == ""))
											{
												$contact = $contact. " ".$incident_person->person_last;
											}
											if(!(!$incident_person->person_phone || $incident_person->person_phone == ""))
											{
												if($contact != "")
												{
													$contact = $contact."<br/>";
												}
												$contact = $contact. "Phone: ".$incident_person->person_phone;
											}
											if(!(!$incident_person->person_email || $incident_person->person_email == ""))
											{
												if($contact != "")
												{
													$contact = $contact."<br/>";
												}
												$contact = $contact. "Email: ".$incident_person->person_email;
											}									
											if($contact == "")
											{
												echo "No Contact Info";
											}
											else
											{
												echo $contact;
											}
										}
										?>
								</div>


							</div>
							<?php } ?>

							<?php echo $pagination; ?>

						</div>
						<!-- end reports block -->
					</div>
				</div>
			</div>
		</div>
	</div>
