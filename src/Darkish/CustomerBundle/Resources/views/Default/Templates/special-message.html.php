
<div class="row record-edit page">
    <form role="form">
	<div class="col col-xs-12 col-sm-12  col-md-12 col-lg-12 details">
		
		<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
			<button ui-sref="profile" class="return-button btn btn-sm btn-primary" >
				<div class="dk icon-arrow-right"></div>
				<span class="">
					بازگشت
				</span>
			</button>
			ویرایش
			<button ng-click="save()" class="details-header-button btn btn-sm btn-primary">
				<span class="">ذخیره</span>
				<div class="dk icon-arrow-left"></div>
			</button>
			

		</div>
		<div class="store-create-product details-inner well">



				<div class="form-group">
					<label for="messageText">
                        متن پیام ویژه
                    </label>
					<input type="text" maxlength="255" class="form-control" ng-model="recordFormData.messageText" id="messageText"
                           placeholder="متن پیام ویژه">
				</div>




		</div>

	</div>

    </form>
</div>

