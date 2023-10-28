<div class="modal-body">
	<form role="form" name="frm_node" method="POST" onSubmit="return false">
	   <input type="hidden" name="flag" value="U" readonly />
	   <input type="hidden" name="module" value="Node" readonly />
	   <input type="hidden" name="no" id="no" value="" readonly />
	   <input type="hidden" name="cmp_no" value="<?=$this->cmp_no?>" readonly />
	   <input type="hidden" name="regist_id" value="<?=$this->_userid?>" readonly />
	   <fieldset>
			<div class="form-group">
				
				
				<div class="col-md-12 padding-top07">
					<label for="b_no">Node</label>
					<input type="text" id="ip_addr" name="ip_addr" class="form-control" value="" placeholder="메뉴명을 입력하세요" />
				</div>
				<div class="col-md-12 padding-top07">
					<label for="regist_dt">Port</label>
					<input type="text" id="port" name="port" class="form-control" value="" />
				</div>
				<div class="col-md-12 padding-top07">
					<label for="regist_dt">Nick Name</label>
					<input type="text" id="emp_nm" name="emp_nm" class="form-control" value="" />
				</div>
				
				
			</div>
		</fieldset>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" onclick="Server.save()" >Save</button>
</div>