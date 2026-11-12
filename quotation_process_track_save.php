<?php
include("include/connect.php");
// session_start();
error_reporting(0);

date_default_timezone_set("Asia/Kolkata");
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
	?>
	<div class="box-content">
		<h2>REPORTING</h2>
		<table style="width:100%;">
			<tr>
				<td style="width:15%;"><Label>Feed Back </label></td>
				<td>:</td>
				<td><textarea type="text" name="feedback" id="feedback"></textarea>

				</td>
				<td style="width:15%;">
					<label class="radio">
						<input type="radio" class="ace css-checkbox1" name="billnotbill" id="bill" value="1" checked>
						Billed
					</label></td>
					<td >:</td>
					<td > <label class="radio">
						<input type="radio" class="ace css-checkbox1" name="billnotbill" id="notbill" value="2"> 
						Not Billed
					</label>   </td>


				</tr>

			</table>
			<hr style="border:1px solid #2fb87a;height: 0px;">
			<div id="billadd"> 
				<table style="width:100%;">
					<tr>
						<td style="width:15%;">
							<Label>Bill no</label></td>
								<td>:</td>
								<td><input class="form-control" name="billno" id="billno" placeholder="Enter Billno" type="text" /></td>
								<td style="width:15%;">
									<Label>Pay Mode</label></td>
										<td>:</td>
										<td><input class="form-control" name="paymode" id="paymode" placeholder="Enter paymode" type="text" /></td>
									</tr>

									<tr>
										<td style="width:15%;">
											<Label>Amount</label></td>
												<td>:</td>
												<td><input class="form-control" name="amount" id="amount" placeholder="Enter amount" type="text" /></td>
												<td style="width:15%;">
													<Label>Balance</label></td>
														<td>:</td>
														<td><input  class="form-control" name="balance" id="balance" placeholder="Enter balance Amount" type="text" /></td>
													</tr>

													<tr>
														<td style="width:15%;">
															<Label>Payment Date</label></td>
																<td>:</td>
																<td style="width:15%;"><input class="form-control" name="paymentdate" id="paymentdate" placeholder="Select paymentdate" type="text" /></td>
															</tr>
														</table>

														<table style="width:100%;">
															<tr>
																<td style="width:15%;"><Label>Feed Back </label></td>
																<td>:</td>
																<td><textarea type="text" name="feedback" id="feedback"></textarea>

																</td>
																<td style="width:15%;">
																	<label class="radio">
																		<input type="radio" class="ace css-checkbox1" name="billnotbill" id="bill" value="1" checked>
																		Billed
																	</label></td>
					<td >:</td>
					<td > <label class="radio">
						<input type="radio" class="ace css-checkbox1" name="billnotbill" id="notbill" value="2"> 
						Not Billed
					</label>   </td>


				</tr>

			</table>
													</div>
												</div>
												<script>
												alert($('#bill').val());
													$('#billadd').hide();
													$(".css-checkbox1").click(function () {
														if ($(this).attr('id') == "bill") {
															$('#billadd').show();

														} 
														else
														{
															$('#billadd').hide();

														}
													});

													$(function(){ $( "#paymentdate" ).datepicker({ dateFormat: 'yy-mm-dd' }); });
												</script>
												<?php
												echo "hi1";
											}    ?>


