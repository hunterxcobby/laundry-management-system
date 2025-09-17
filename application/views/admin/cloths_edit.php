<div class="">
													<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
													echo form_open('admin/cloth_crud/create',$attributes); ?>
													
													<div class="form-group ">
														<label class="col-sm-3 control-label no-padding-right" for="cloth_id"> Cloth ID : </label>

														<div class="col-sm-9">
															<input type="text" id="cloth_id" class="form-control" required readonly value="<?php echo $last_id+1; ?>" />
														</div>
													</div>
													
													<div class="space-4"></div>
													
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="cloth_name"> Cloth Name OLD  (English) : </label>

														<div class="col-sm-9">
															<input type="text" name="cloth_name" class="form-control" required  autofocus/>
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="cloth_name"> Cloth Name ( <?php echo ucwords($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_lang); ?> ) : </label>

														<div class="col-sm-9">
															<input type="text" name="cloth_name_lang" class="form-control" required  />
														</div>
													</div>
													

													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="cloth_code"> Cloth Description : </label>

														<div class="col-sm-9">
															<input type="text" name="cloth_code" class="form-control" />
														</div>
													</div>
													
													
													<div class="form-group">
											
							
														<label class="col-sm-3 control-label no-padding-right" for="garment_image"> Image  : </label>

														<div class="col-sm-9">
															<input type="file" name="garment_image" id="garment_image" class="form-control" />
														</div>
													</div>
										


													<div class="clearfix form-actions">
														<div class="col-md-offset-3 col-md-9">
															<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; Save &nbsp;&nbsp;&nbsp;">
																
																&nbsp; &nbsp; &nbsp;														
																&nbsp; &nbsp; &nbsp;
															<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
																
															
														</div>
													</div>
													
													</form>
												Note : <a href="https://translate.google.co.in/" target="_blank"> Google Translate </a> 