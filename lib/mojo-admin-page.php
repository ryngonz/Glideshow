<div class="wrap">
<h2>Glideshow</h2>
<p>To call the slider, use the shortcode [glideshow]</p>
<form name="glideshow_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<table class="form-table">
<tbody>
<tr>
<th scope="row">
	<label for="glideshow_id">Glideshow Div ID</label>
</th>
<td>
	<input name="glideshow_id" type="text" id="glideshow_id" value="<?=$glideshow_id?>" class="regular-text" placeholder="ex. glideshow-id"><br>
	<i>Avoid having spaces.</i>
</td>
</tr>
<tr>
<th scope="row">
	<label for="glideshow_images">Glideshow Maker</label><br>
	<i>row x column<i>
</th>
<td>
	<p>Please select block orientation:</p>
	<div style="display:inline-block; text-align:center;">
		<input type="radio" class="orientaion" name="orientation" value="2x2" /> 
		<table style="width:50px; height:66px;">
			<tr>
				<td style="width:50px; background:black;"></td>
			</tr>
		</table>
	</div>
	<div style="display:inline-block; text-align:center;">
		<input type="radio" class="orientaion" name="orientation" value="2x1-2x1" />
		<table style="width:50px; height:66px;">
			<tr>
				<td style="width:25px; background:black;"></td>
				<td style="width:25px; background:black;"></td>
			</tr>
		</table>
	</div>
	<div style="display:inline-block; text-align:center;">
		<input type="radio" class="orientaion" name="orientation" value="1x2-1x2" />
		<table style="width:50px; height:50px;">
			<tr>
				<td colspan="2" style="width:50px; background:black;"></td>
			</tr>
			<tr>
				<td colspan="2" style="width:50px; background:black;"></td>
			</tr>
		</table>
	</div>
	<div style="display:inline-block; text-align:center;"> 
		<input type="radio" class="orientaion" name="orientation" value="1x2-1x1-1x1" />
		<table style="width:50px; height:50px;">
			<tr>
				<td colspan="2" style="width:50px; background:black;"></td>
			</tr>
			<tr>
				<td style="width:25px; background:black;"></td>
				<td style="width:25px; background:black;"></td>
			</tr>
		</table>
	</div>
	<div style="display:inline-block; text-align:center;">
		<input type="radio" class="orientaion" name="orientation" value="1x1-1x1-1x2" />
		<table style="width:50px; height:50px;">
			<tr>
				<td style="width:25px; background:black;"></td>
				<td style="width:25px; background:black;"></td>
			</tr>
			<tr>
				<td colspan="2" style="width:50px; background:black;"></td>
			</tr>
		</table>
	</div>
	<div style="display:inline-block; text-align:center;">
		<input type="radio" class="orientaion" name="orientation" value="2x1-1x1-1x1" />
		<table style="width:50px; height:50px;">
			<tr>
				<td rowspan="2" style="width:50px; background:black;"></td>
				<td style="width:25px; background:black;"></td>
			</tr>
			<tr>
				<td style="width:25px; background:black;"></td>
			</tr>
		</table>
	</div>
	<div style="display:inline-block; text-align:center;">
		<input type="radio" class="orientaion" name="orientation" value="1x1-2x1-1x1" />
		<table style="width:50px; height:50px;">
			<tr>
				<td style="width:25px; background:black;"></td>
				<td rowspan="2" style="width:50px; background:black;"></td>
			</tr>
			<tr>
				<td style="width:25px; background:black;"></td>
			</tr>
		</table>
	</div>
	<div style="display:inline-block; text-align:center;">
		<input type="radio" class="orientaion" name="orientation" value="1x1-1x1-1x1-1x1" />
		<table style="width:50px; height:50px;">
			<tr>
				<td style="width:25px; background:black;"></td>
				<td style="width:25px; background:black;"></td>
			</tr>
			<tr>
				<td style="width:25px; background:black;"></td>
				<td style="width:25px; background:black;"></td>
			</tr>
		</table>
	</div>
	<p><button class="button" id="insert-block">Insert Block</button></p>
	<div id="glideshow-maker">
		<?php
			if(is_array($glideshow_glides) || is_object($glideshow_glides)){
				$countFieldsets = 0;
				foreach($glideshow_glides as $block){
					echo "<fieldset>";
					$count = 0;
					foreach($block as $index => $val){
						if($index == "blockName"){
							$blockName = $val;
							echo "<legend>".$val." - <span class='remove-block'><i>remove</i></span></legend>";
						}else{
							$html = "";
							$image = "";
							if($val->type == "HTML"){
								$html = "selected";
							}else{
								$image = "selected";	
							}
							
							echo "<strong>".$val->orientation.": </strong><select name='glides[".$countFieldsets."][".$count."][type]'>";
							echo "<option ".$html.">HTML</option>";
							echo "<option ".$image.">Image</option>";
							echo "</select>";
							echo "<input type='color' name='glides[".$countFieldsets."][".$count."][color]' value='".$val->color."' />";
							echo "<input type='text' name='glides[".$countFieldsets."][".$count."][content]' value='".$val->content."' class='large-text' />";
							echo "<input type='hidden' name='glides[".$countFieldsets."][".$count."][orientation]' value=".$val->orientation." class='large-text' />";
						}
						$count++;
					}
					echo "<input type='hidden' name='glides[".$countFieldsets."][blockName]' value='".$blockName."' /></fieldset>";
					echo "</fieldset>";
					$countFieldsets++;
				}
			}
		?>
	</div>
</td>
</tr>	
<tr>
<th scope="row">
	<label for="glideshow_custom_css">Glideshow Custom CSS</label>
</th>
<td>
	<textarea id="glideshow_custom_css" name="glideshow_custom_css" class="large-text code" cols="50" rows="10"><?=$glideshow_custom_css?></textarea><br>
</td>
</tr>
</tbody></table>
<p class="submit">
	<input type="hidden" name="update_settings" value="1" />
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
</p>
</form>
<?php if($console){ ?>
<strong>Console</strong>
<pre>
	<?php
		print_r($glideshow_glides);
	?>
</pre>
<?php } ?>
</div>
<style>
	#glideshow-maker{
		background:#FFF;
		border:#FAFAFA;
		margin-top:20px;
		display:table;
		width:100%;
	}
	fieldset{
		margin:15px 15px;
		border:1px solid #333;
		padding:15px;
	}

	fieldset legend{
		font-weight:bold;
	}

	.remove-block{
		font-weight:normal;
		color:#F00;
		cursor:pointer;
	}
</style>

<script type="text/javascript">
	jQuery("#insert-block").live( "click", function() {
		var selectedVal = "";
		var selected = jQuery("input[type='radio'][class='orientaion']:checked");
		if (selected.length > 0) {
		    selectedVal = selected.val();
		}
		
		generateBlock(selectedVal);
		return false;
	});

	jQuery(".remove-block").live( "click", function() {
		if(confirm("Are you sure you want to continue")){
			jQuery(this).parent().parent().remove();
		}
	});

	function generateBlock(block){
		var appendBlock = "";
		var countFieldsets = jQuery("fieldset").length;
		var blocks = block.split("-");
		appendBlock += "<fieldset><legend>"+block+" - <span class='remove-block'><i>remove</i></span></legend>";

		if(block == "2x2"){
			appendBlock += generateEntry(block, countFieldsets, 0);
		}else if(block != "2x2" && block != ""){
			for (i = 0; i < blocks.length; i++) { 
			    appendBlock += generateEntry(blocks[i], countFieldsets, i);
			}
		}else{
		    alert("Please select a block orientation.");
		    return false;
		}

		appendBlock += "<input type='hidden' name='glides["+countFieldsets+"][blockName]' value='"+block+"' /></fieldset>";
		jQuery("#glideshow-maker").append(appendBlock);
	}

	function generateEntry(block, countFieldsets, count){

		var returnField = "";
		returnField += "<strong>"+block+": </strong><select name='glides["+countFieldsets+"]["+count+"][type]'><option>HTML</option><option>Image</option></select>";
		returnField += "<input type='color' name='glides["+countFieldsets+"]["+count+"][color]' />";
		returnField += "<input type='text' name='glides["+countFieldsets+"]["+count+"][content]' class='large-text' />";
		returnField += "<input type='hidden' name='glides["+countFieldsets+"]["+count+"][orientation]' value="+block+" class='large-text' />";
		return returnField;
	}
</script>