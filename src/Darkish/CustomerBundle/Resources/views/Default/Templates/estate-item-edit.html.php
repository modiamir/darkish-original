<div class="database-create database-form">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'database'" class="return-button" 
			ui-sref="database.itemdetails({iid: item.id})">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		ویرایش «<b ng-bind="item.title"></b>»
		<button ng-disabled="databaseedit.$invalid" ng-click="saveItem()" class="details-header-button btn btn-sm btn-primary">
			<span class="">ذخیره</span>
			<div class="dk icon-arrow-left"></div>
		</button>
	</div>
	<div class="database-create-estate details-inner well">
		<form name="databaseedit">
			<div class="row">
				<div class="col col-xs-12 col-sm-8 form-group">
				  <label class="control-label" for="estate-title">عنوان فایل<span class="required-field">*</span></label>
				  <input    class="form-control" id="estate-title" type="text"
				  		 placeholder="عنوان فایل" ng-model="item.title"
				  		 maxlength="100" required>
				</div>
				<div class="col col-xs-12 col-sm-4 form-group">
				  <label class="control-label" for="estate-code">کد فایل<span class="required-field">*</span></label>
				  <input    class="form-control" id="estate-code" type="number"
				  		 minlength="1" maxlength="4" placeholder="کد فایل" ng-model="item.code"
				  		required>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="estate-contract-type">نوع واگذاری<span class="required-field">*</span></label>
				  <select    class="form-control" id="estate-contract-type" ng-model="item.contract_type"
				  			ng-options="contractType.value for contractType in contractTypes"
				  			required>
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="estate-type">نوع ملک<span class="required-field">*</span></label>
				  <select    class="form-control" id="estate-type" ng-model="item.estate_type"
				  			ng-options="estateType.value for estateType in estateTypes"
				  			required>
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label ng-show="item.contract_type.id != 2" class="control-label" for="price">قیمت</label>
				  	<label ng-show="item.contract_type.id == 2" class="control-label" for="price">رهن</label>
				  	<input    class="form-control" id="price" type="number"
				  		minlength="1" maxlength="12" ng-model="item.price"
				  	>

			  		<label ng-show="item.contract_type.id == 2" class="control-label" for="estate-code">اجاره</label>
				  	<input    ng-show="item.contract_type.id == 2" class="form-control" id="estate-code" type="number"
				  		minlength="1" maxlength="12" ng-model="item.secondary_price"
				  	>


				</div>


				<div class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-dimension">متراژ</label>
					<input    class="form-control" id="estate-dimension" type="number"
							 placeholder="متراژ" ng-model="item.dimension"
							 maxlength="5">
				</div>


				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  	<label class="control-label" for="estate-num-of-rooms">تعداد اتاق</label>
				  	<select    class="form-control" id="estate-num-of-rooms" ng-model="item.num_of_rooms">
		            	<option ng-selected="item.num_of_rooms == key" ng-repeat="key in [1,2,3,4,5,6,7,8,9,10]" value="{{key}}">{{key}}</option>
		          	</select>
				</div>


				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-floor">طبقه</label>
					<input    class="form-control" id="estate-floor" type="number"
							 placeholder="طبقه" ng-model="item.floor"
							 maxlength="2">
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-region">منطقه/بازار</label>
					<input    class="form-control" id="estate-region" type="text"
							 placeholder="منطقه/بازار" ng-model="item.region"
							 maxlength="20">
				</div>

				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-age">سن بنا</label>
					<input    class="form-control" id="estate-age" type="number"
							 placeholder="سن بنا" ng-model="item.age"
							 maxlength="2">
				</div>

				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 form-group database-features">
					<label class="control-label">امکانات</label>
					<ul>
						<li ng-repeat="feature in estateFeatures">
							<label for="estate-feature-{{feature.id}}">{{feature.value}}</label>
							<input    ng-model="item.estate_features[feature.id]" id="estate-feature-{{feature.id}}" type="checkbox" value="feature.value" />
						</li>
					</ul>
				</div>

				<div class="col col-xs-12 form-group">
					<label class="control-label" for="description">توضیحات</label>
					<textarea    class="form-control" id="description" type="text"
						placeholder="توضیحات" ng-model="item.description" 
						rows="4" maxlength="1000">
					</textarea>
				</div>



			    
			</div>
			

			<hr/>
			<div class="row">

	            <div class="col-md-12" style="margin-bottom: 40px">
	                <h3>بارگذاری تصویر (پنج تصویر)
		                <label ng-disabled="item.photos.length >= 5" class="btn btn-info btn-sm">
		                	انتخاب فایل
		                	<input type="file" ng-show="false" nv-file-select="" uploader="uploader" multiple  /><br/>
		                </label>
	                </h3>
	                <div class="progress" style="">
                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                    </div>
                    <hr ng-show="item.photos"/>
                    <div class="row" ng-show="item.photos">
                    	<div class="col col-xs-12 col-sm-6 col-md-3" ng-repeat="photo in item.photos">
                    		<div class="image-thumb">
	                    		<img ng-src="{{photo.icon_absolute_path}}" />
	                    		<button class="thumbnail-remove btn btn-danger btn-xs" ng-click="removePhoto($index)"><div class="dk icon-remove"></div></button>
                    		</div>
                    	</div>
                    </div>

	            </div>

	        </div>

			
		</form>

	</div>
</div>