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
	<div class="database-create-automobile details-inner well">
		<form name="automobilecreate">
			<div class="row">
				
				<div class="col col-xs-12 col-sm-8 form-group">
				  <label class="control-label" for="automobile-title">عنوان فایل</label>
				  <input ng-disabled="true" class="form-control" id="automobile-title" type="text"
				  		 placeholder="عنوان فایل" ng-model="item.title"
				  		 maxlength="50" required>
				</div>
				<div class="col col-xs-12 col-sm-4 form-group">
				  <label class="control-label" for="automobile-code">کد فایل</label>
				  <input ng-disabled="true" class="form-control" id="automobile-code" type="number"
				  		 minlength="1" maxlength="4" placeholder="کد فایل" ng-model="item.code"
				  		>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-brand">برند</label>
				  <select ng-disabled="true" class="form-control" id="automobile-brand" ng-model="item.automobile_brand"
				  			ng-options="automobileBrand.value for automobileBrand in automobileBrands">
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-type">نوع</label>
				  <select ng-disabled="true" class="form-control" id="automobile-type" ng-model="item.automobile_type"
				  			ng-options="automobileType.value for automobileType in automobileTypes | filter: {parent_id: item.automobile_brand.id}">
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="price">قیمت</label>
				  	<input ng-disabled="true" class="form-control" id="price" type="number"
				  		minlength="1" maxlength="4" ng-model="item.price"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  	<label class="control-label" for="automobile-age">سال ساخت</label>
				  	<select ng-disabled="true" class="form-control" id="automobile-age" ng-model="item.created_year">
				  		<option ng-selected="age == item.created_year" ng-repeat="age in ages" value="{{age}}"> {{age}}</option>
		            
		          	</select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-color">رنگ</label>
				  <select ng-disabled="true" class="form-control" id="automobile-color" ng-model="item.automobile_color"
				  			ng-options="automobileColor.value for automobileColor in automobileColors">
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="automobile-usage">کارکرد</label>
				  	<input ng-disabled="true" class="form-control" id="automobile-usage" type="number"
				  		minlength="1" maxlength="4" ng-model="item.usage"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="automobile-tip">تیپ</label>
				  	<input ng-disabled="true" class="form-control" id="automobile-tip" type="text"
				  		minlength="1" maxlength="4" ng-model="item.tip"
				  	>

				</div>

				<div class="col col-xs-12 form-group database-features">
					<label class="control-label">امکانات</label>
					<ul>
						<li ng-repeat="feature in automobileFeatures">
							<label for="automobile-feature-{{feature.id}}">{{feature.value}}</label>
							<input ng-disabled="true" ng-model="item.automobile_features[feature.id]" id="automobile-feature-{{feature.id}}" type="checkbox" value="feature.value" />
						</li>
					</ul>
				</div>
				<div class="col col-xs-12 form-group">
					<label class="control-label" for="description">توضیحات</label>
					<textarea ng-disabled="true" class="form-control" id="description" type="text"
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