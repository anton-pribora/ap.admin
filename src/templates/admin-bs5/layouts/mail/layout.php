<?php
/* @var $this ApCode\Template\Layout\LayoutInterface */
?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->renderIfNotEmpty('head.title')?>
<?php echo $this->renderIfNotEmpty('head.metas')?>
<?php echo $this->renderIfNotEmpty('head.html')?>
<?php echo $this->renderIfNotEmpty('head.css.links')?>
<?php echo $this->renderIfNotEmpty('head.js.links')?>
<?php echo $this->renderIfNotEmpty('head.css.code')?>
<?php echo $this->renderIfNotEmpty('head.js.code')?>
</head>

<body>
<?php echo $this->renderIfNotEmpty('body.css.code')?>
<center>
<table border="0" cellpadding="0" cellspacing="0" height="100%"
	width="100%" id="bodyTable">
	<tr>
		<td align="center" valign="top" id="bodyCell">
			<!-- EMAIL CONTAINER // --> <!--
                	The table "emailBody" is the email's container.
                    Its width can be set to 100% for a color band
                    that spans the width of the page.
                -->
			<table border="0" cellpadding="0" cellspacing="0" width="600"
				id="emailBody">


				<!-- MODULE ROW // -->
				<!--
                    	To move or duplicate any of the design patterns
                        in this email, simply move or copy the entire
                        MODULE ROW section for each content block.
                    -->
				<tr>
					<td align="center" valign="top">
						<!-- CENTERING TABLE // --> <!--
                            	The centering table keeps the content
                                tables centered in the emailBody table,
                                in case its width is set to 100%.
                            -->
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align="center" valign="top">
									<!-- FLEXIBLE CONTAINER // --> <!--
                                        	The flexible container has a set width
                                            that gets overridden by the media query.
                                            Most content tables within can then be
                                            given 100% widths.
                                        -->
									<table border="0" cellpadding="0" cellspacing="0" width="600"
										class="flexibleContainer">
										<tr>
											<td align="center" valign="top" width="600"
												class="flexibleContainerCell">
												<!-- CONTENT TABLE // --> <!--
                                                    	The content table is the first element
                                                        that's entirely separate from the structural
                                                        framework of the email.
                                                    -->
												<table border="0" cellpadding="0" cellspacing="0"
													width="100%">
													<tr>
														<td valign="top" class="textContent">
<?php echo $this->renderIfNotEmpty('body.content')?>
                                                            </td>
													</tr>
												</table> <!-- // CONTENT TABLE -->


												</td>
											</tr>
										</table> <!-- // FLEXIBLE CONTAINER -->
									</td>
								</tr>
							</table> <!-- // CENTERING TABLE -->
						</td>
					</tr>
					<!-- // MODULE ROW -->

				</table> <!-- // EMAIL CONTAINER -->
			</td>
		</tr>
	</table>
</center>

<?php echo $this->renderIfNotEmpty('body.js.links')?>
<?php echo $this->renderIfNotEmpty('body.js.code')?>

  </body>
</html>
