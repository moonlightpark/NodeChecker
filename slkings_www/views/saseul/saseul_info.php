<script type="text/javascript">
<!--
$(document).ready(function(){
	
});


//-->
</script>
<div id="page-wrapper">
	<div class="row padding-top20">
		<!-- customer_info -->
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					가맹점 관리
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">					
					<!-- Search -->
					<div class="row">
						<div class="col-lg-12">

						
							<div class="col-md-6">
								<div class="form-group">
									<label>ID</label>
									<input type="text" name="emp_id" class="form-control" value="<?=$this->ShopInfoRs[0]['emp_id']?>" maxlength="20" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>비밀번호</label>
									<input type="password" name="emp_pwd" class="form-control" value="" maxlength="200" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>가맹점 상호명</label>
									<input type="text" name="shop_name" class="form-control" value="<?=$this->ShopInfoRs[0]['shop_name']?>" maxlength="50" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>전화번호</label>
									<input type="text" name="tel_no" class="form-control" value="<?=$this->ShopInfoRs[0]['tel_no']?>" maxlength="200" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>가맹점 사업자번호</label>
									<input type="text" name="shop_regist_no" class="form-control" value="<?=$this->ShopInfoRs[0]['shop_regist_no']?>" maxlength="50" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>가맹점 주소</label>
									<input type="text" name="shop_addr" class="form-control" value="<?=$this->ShopInfoRs[0]['shop_addr']?>" maxlength="200" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>플랫폼</label>
									<input type="text" name="platform" class="form-control" value="<?=$this->ShopInfoRs[0]['platform']?>" maxlength="50" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>월렛 주소</label>
									<input type="text" name="token_addr" class="form-control" value="<?=$this->ShopInfoRs[0]['token_addr']?>" maxlength="200" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>이메일</label>
									<input type="text" name="email_addr" class="form-control" value="<?=$this->ShopInfoRs[0]['email_addr']?>" maxlength="50" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>접속 IP</label>
									<input type="text" name="ip_addr" class="form-control" value="<?=$this->ShopInfoRs[0]['ip_addr']?>" maxlength="200" />
								</div>
							</div>





						</div>


						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
							<button type="button" class="btn btn-primary" onclick="EmployDlg.save()">저장</button>
						</div>







					</div>
					<!-- /.table-responsive -->
					  
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
	<!-- /.row -->
</div>
<!-- /.col-lg-10 -->
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->






