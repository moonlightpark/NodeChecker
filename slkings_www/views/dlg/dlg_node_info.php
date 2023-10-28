<div class="modal-body">
	<form role="form" name="frm_menupan" method="POST" onSubmit="return false">
	   <input type="hidden" name="flag" value="I" readonly />
	   <input type="hidden" name="module" value="Menupan" readonly />
	   <input type="hidden" name="cmp_no" value="<?=$this->cmp_no?>" readonly />
	   <input type="hidden" name="regist_id" value="<?=$this->_userid?>" readonly />
	   <fieldset>
			<div class="form-group">
				
				
				<div class="col-md-12 padding-top07">
					<label for="b_no">All Node Log Check...</label>
				</div>

				<div class="col-md-12 padding-top07">
					<label for="b_no">please wait for a moment. This operation may impose network load on the node.</label>
				</div>
							
				<div class="col-md-12 padding-top07">
					<label for="b_no"><font color="red">Warning: Do not use repeatedly.</font></label>
				</div>
				
				
			</div>
		</fieldset>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" onclick="Server.refresh();">Close</button>
</div>
