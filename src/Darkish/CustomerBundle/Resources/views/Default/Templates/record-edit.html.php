
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

            <div class="row">
				<div class="form-group col col-xs-12 col-sm-4">
					<label for="owner">
                        نام مالک
                    </label>
					<input type="text" class="form-control" ng-model="recordFormData.owner" id="owner"
                           maxlength="255"
                           placeholder="نام مالک" >
				</div>

				<div class="form-group col col-xs-12 col-sm-4">
					<label for="ownerMail">
                        پست الکترونیک مالک
                    </label>
					<input type="email" maxlength="255" class="form-control" ng-model="recordFormData.ownerMail" id="ownerMail"
                           placeholder="پست الکترونیک مالک">
				</div>

				<div class="form-group col col-xs-12 col-sm-4">
					<label for="ownerPhone">
                        تلفن مالک
                    </label>
					<input type="text" maxlength="11" class="form-control" ng-model="recordFormData.ownerPhone" id="ownerPhone"
                           placeholder="تلفن مالک">
				</div>
            </div>
            <div class="row">
				<div class="form-group col col-xs-12 col-sm-4">
					<label for="manager">
                        نام مدیر
                    </label>
					<input maxlength="255" type="text" class="form-control" ng-model="recordFormData.manager" id="manager"
                           placeholder="نام مدیر">
				</div>

				<div class="form-group col col-xs-12 col-sm-4">
					<label for="managerMail">
                        پست الکترونیک مدیر
                    </label>
					<input type="email" maxlength="255" class="form-control" ng-model="recordFormData.managerMail" id="managerMail"
                           placeholder="پست الکترونیک مدیر">
				</div>

				<div class="form-group col col-xs-12 col-sm-4">
					<label for="managerPhone">
                        تلفن مدیر
                    </label>
					<input maxlength="11" type="text" class="form-control" ng-model="recordFormData.managerPhone" id="managerPhone"
                           placeholder="تلفن مدیر">
				</div>
            </div>


            <div class="row">
				<div class="form-group col col-xs-12 col-sm-3">
					<label for="telNumberOne">
تلفن
                    </label>
                    <input type="text" class="form-control" ng-model="recordFormData.telNumberOneLabel" id="telNumberOneLabel"
                           maxlength="255" placeholder="عنوان">
                    <input type="text" maxlength="11" class="form-control" ng-model="recordFormData.telNumberOne" id="telNumberOne"
                           placeholder="شماره">
				</div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="telNumberTwo">
تلفن
                    </label>
                    <input type="text" maxlength="255" class="form-control" ng-model="recordFormData.telNumberTwoLabel" id="telNumberTwoLabel"
                           placeholder="عنوان">
                    <input type="text" maxlength="11" class="form-control" ng-model="recordFormData.telNumberTwo" id="telNumberTwo"
                           placeholder="شماره">
				</div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="telNumberThree">
تلفن
                    </label>
                    <input type="text" maxlength="255" class="form-control" ng-model="recordFormData.telNumberThreeLabel" id="telNumberThreeLabel"
                           placeholder="عنوان">
                    <input type="text" maxlength="11" class="form-control" ng-model="recordFormData.telNumberThree" id="telNumberThree"
                           placeholder="شماره">
				</div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="telNumberFour">
                        تلفن
                    </label>
                    <input type="text" maxlength="255" class="form-control" ng-model="recordFormData.telNumberFourLabel" id="telNumberFourLabel"
                           placeholder="عنوان">
                    <input type="text" maxlength="11" class="form-control" ng-model="recordFormData.telNumberFour" id="telNumberFour"
                           placeholder="شماره">
				</div>

            </div>
            <div class="row">
				<div class="form-group col col-xs-12 col-sm-3">
					<label for="faxNumberOne">
                        فکس
                    </label>
					<input type="text" maxlength="11" class="form-control" ng-model="recordFormData.faxNumberOne" id="faxNumberOne"
                           placeholder="فکس">
				</div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="faxNumberTwo">
                        فکس
                    </label>
					<input type="text" maxlength="11" class="form-control" ng-model="recordFormData.faxNumberTwo" id="faxNumberTwo"
                           placeholder="فکس">
				</div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="mobileNumberOne">
                        تلفن همراه
                    </label>
					<input type="text" maxlength="11" class="form-control" ng-model="recordFormData.mobileNumberOne" id="mobileNumberOne"
                           placeholder="تلفن همراه">
				</div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="mobileNumberTwo">
                        تلفن همراه
                    </label>
					<input type="text" maxlength="11" class="form-control" ng-model="recordFormData.mobileNumberTwo" id="mobileNumberTwo"
                           placeholder="تلفن همراه">
				</div>
            </div>

            <div class="row">
                <div class="form-group col col-xs-12 col-sm-3">
                    <label for="email">
                        پست الکترونیک
                    </label>
                    <input type="email" maxlength="255" class="form-control" ng-model="recordFormData.email" id="email"
                           placeholder="پست الکترونیک">
                </div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="website">
                        وبسایت
                    </label>
					<input type="text" maxlength="255" class="form-control" ng-model="recordFormData.website" id="website"
                           placeholder="وبسایت">
				</div>

				<div class="form-group col col-xs-12 col-sm-3 col col-xs-12 col-sm-3">
					<label for="smsNumber">
                        شماره پیامک
                    </label>
					<input type="text" maxlength="14"  class="form-control" ng-model="recordFormData.smsNumber" id="smsNumber"
                           placeholder="شماره پیامک">
				</div>

				<div class="form-group col col-xs-12 col-sm-3">
					<label for="postalCode">
                        کد پستی
                    </label>
					<input type="text" maxlength="10" class="form-control" ng-model="recordFormData.postalCode" id="postalCode"
                           placeholder="کد پستی">
				</div>
            </div>

<!--				<div class="form-group">-->
<!--					<label for="messageText">-->
<!--                        متن پیام ویژه-->
<!--                    </label>-->
<!--					<input type="text" class="form-control" ng-model="recordFormData.messageText" id="messageText"-->
<!--                           placeholder="متن پیام ویژه">-->
<!--				</div>-->

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label class="checkbox-inline">
                            <input type="checkbox" ng-model="recordFormData.sellServicePageCustomer">
                            نمایش فروشگاه
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" ng-model="recordFormData.dbaseEnableCustomer">
                            نمایش بانک
                        </label>

                        <label class="checkbox-inline">
                            <input type="checkbox" ng-model="recordFormData.commentableCustomer">
                            نمایش نظرات
                        </label>
                    </div>
                </div>






		</div>

	</div>

    </form>
</div>

