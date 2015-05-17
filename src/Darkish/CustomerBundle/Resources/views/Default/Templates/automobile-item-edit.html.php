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
	<div class="database-create-automobile details-inner well">
		<form name="databaseedit">
			<div class="row">
				
				<div class="col col-xs-12 col-sm-8 form-group">
				  <label class="control-label" for="automobile-title">عنوان فایل<span class="required-field">*</span></label>
				  <input   class="form-control" id="automobile-title" type="text"
				  		 placeholder="تیتر آگهی" ng-model="item.title"
				  		 maxlength="100" required>
				</div>
				<div class="col col-xs-12 col-sm-4 form-group">
				  <label class="control-label" for="automobile-code">کد فایل<span class="required-field">*</span></label>
				  <input   class="form-control" id="automobile-code" type="number"
				  		 minlength="1" maxlength="4" placeholder="کد آگهی" ng-model="item.code" required
				  		>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-brand">برند<span class="required-field">*</span></label>
				  <select   class="form-control" id="automobile-brand" ng-model="item.automobile_brand"
				  			ng-options="automobileBrand.value for automobileBrand in automobileBrands"
				  			required>
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-type">نوع<span class="required-field">*</span></label>
				  <select   class="form-control" id="automobile-type" ng-model="item.automobile_type"
				  			ng-options="automobileType.value for automobileType in automobileTypes | filter: {parent_id: item.automobile_brand.id}"
				  			required>
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="price">قیمت</label>
				  	<input   class="form-control" id="price" type="number"
				  		minlength="1" maxlength="10" ng-model="item.price"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  	<label class="control-label" for="automobile-age">سال ساخت<span class="required-field">*</span></label>
				  	<select   class="form-control" id="automobile-age" ng-model="item.created_year"
				  			required>
				  		<option ng-selected="age == item.created_year" ng-repeat="age in ages" value="{{age}}"> {{age}}</option>
		            
		          	</select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-color">رنگ</label>
				  <select   class="form-control" id="automobile-color" ng-model="item.automobile_color"
				  			ng-options="automobileColor.value for automobileColor in automobileColors">
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="automobile-usage">کارکرد</label>
				  	<input   class="form-control" id="automobile-usage" type="number"
				  		minlength="1" maxlength="6" ng-model="item.usage"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="automobile-tip">تیپ</label>
				  	<input   class="form-control" id="automobile-tip" type="text"
				  		minlength="1" maxlength="20" ng-model="item.tip"
				  	>

				</div>

				<div class="col col-xs-12 form-group database-features">
					<label class="control-label">امکانات</label>
					<ul>
						<li ng-repeat="feature in automobileFeatures">
							<label for="automobile-feature-{{feature.id}}">{{feature.value}}</label>
							<input   ng-model="item.automobile_features[feature.id]" id="automobile-feature-{{feature.id}}" type="checkbox" value="feature.value" />
						</li>
					</ul>
				</div>
				<div class="col col-xs-12 form-group">
					<label class="control-label" for="description">توضیحات</label>
					<textarea   class="form-control" id="description" type="text"
						placeholder="توضیحات" ng-model="item.description" 
						rows="4">
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