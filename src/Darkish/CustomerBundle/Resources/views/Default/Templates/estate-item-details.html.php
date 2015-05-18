<div class="database-create database-form">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'database'" class="return-button" 
			ui-sref="database">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		{{item.title}}
		<button  ui-sref="database.itemedit({iid:item.id})" class="details-header-button btn btn-sm btn-primary">
			<div class="dk icon-edit"></div>
			<span class="">ویرایش</span>			
		</button>
	</div>
	<div class="database-create-estate details-inner well">
		<form name="databasecreate">
			<div class="row">
				<div class="col col-xs-12 col-sm-8 form-group">
				  <label class="control-label" for="estate-title">عنوان فایل</label>
				  <input ng-disabled="true"  class="form-control" id="estate-title" type="text"
				  		 placeholder="عنوان فایل" ng-model="item.title"
				  		 maxlength="50" required>
				</div>
				<div class="col col-xs-12 col-sm-4 form-group">
				  <label class="control-label" for="estate-code">کد فایل</label>
				  <input ng-disabled="true"  class="form-control" id="estate-code" type="number"
				  		 minlength="1" maxlength="4" placeholder="کد فایل" ng-model="item.code"
				  		>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="estate-contract-type">نوع واگذاری</label>
				  <select ng-disabled="true"  class="form-control" id="estate-contract-type" ng-model="item.contract_type"
				  			ng-options="contractType.value for contractType in contractTypes">
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="estate-type">نوع ملک</label>
				  <select ng-disabled="true"  class="form-control" id="estate-type" ng-model="item.estate_type"
				  			ng-options="estateType.value for estateType in estateTypes">
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label ng-show="item.contract_type.id != 2" class="control-label" for="price">قیمت</label>
				  	<label ng-show="item.contract_type.id == 2" class="control-label" for="price">رهن</label>
				  	<input ng-disabled="true"  class="form-control" id="price" type="number"
				  		minlength="1" maxlength="4" ng-model="item.price"
				  	>

			  		<label ng-show="item.contract_type.id == 2" class="control-label" for="estate-code">اجاره</label>
				  	<input ng-disabled="true"  ng-show="item.contract_type.id == 2" class="form-control" id="estate-code" type="number"
				  		minlength="1" maxlength="4" ng-model="item.secondary_price"
				  	>


				</div>


				<div class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-dimension">متراژ</label>
					<input ng-disabled="true"  class="form-control" id="estate-dimension" type="number"
							 placeholder="متراژ" ng-model="item.dimension"
							 maxlength="50">
				</div>


				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  	<label class="control-label" for="estate-num-of-rooms">تعداد اتاق</label>
				  	<select ng-disabled="true"  class="form-control" id="estate-num-of-rooms" ng-model="item.num_of_rooms">
		            	<option ng-selected="item.num_of_rooms == key" ng-repeat="key in [1,2,3,4,5,6,7,8,9,10]" value="{{key}}">{{key}}</option>
		          	</select>
				</div>


				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-floor">طبقه</label>
					<input ng-disabled="true"  class="form-control" id="estate-floor" type="number"
							 placeholder="طبقه" ng-model="item.floor"
							 maxlength="50">
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-region">منطقه/بازار</label>
					<input ng-disabled="true"  class="form-control" id="estate-region" type="text"
							 placeholder="منطقه/بازار" ng-model="item.region"
							 maxlength="50">
				</div>

				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-age">سن بنا</label>
					<input ng-disabled="true"  class="form-control" id="estate-age" type="number"
							 placeholder="سن بنا" ng-model="item.age"
							 maxlength="50">
				</div>

				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 form-group database-features">
					<label class="control-label">امکانات</label>
					<ul>
						<li ng-repeat="feature in estateFeatures">
							<label for="estate-feature-{{feature.id}}">{{feature.value}}</label>
							<input ng-disabled="true"  ng-model="item.estate_features[feature.id]" id="estate-feature-{{feature.id}}" type="checkbox" value="feature.value" />
						</li>
					</ul>
				</div>

				<div class="col col-xs-12 form-group">
					<label class="control-label" for="description">توضیحات</label>
					<textarea ng-disabled="true"  class="form-control" id="description" type="text"
						placeholder="توضیحات" ng-model="item.description" 
						rows="4">
					</textarea>
				</div>



			    
			</div>
			

			<hr ng-show="item.photos"/>
            <div class="row" ng-show="item.photos">
            	<div class="col col-xs-12 col-sm-6 col-md-3" ng-repeat="photo in item.photos">
            		<div class="image-thumb">
                		<img ng-src="{{photo.icon_absolute_path}}" />
            		</div>
            	</div>
            </div>

			
		</form>

	</div>
</div>