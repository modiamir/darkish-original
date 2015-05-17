<div class="database-create database-form">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'database'" class="return-button" 
			ui-sref="database">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		فایل جدید
		<button ng-disabled="databasecreate.$invalid" ng-click="saveItem()" class="details-header-button btn btn-sm btn-primary">
			<span class="">ذخیره</span>
			<div class="dk icon-arrow-left"></div>
		</button>
	</div>
	<div class="database-create-automobile details-inner well">
		<form name="databasecreate">
			<div class="row">
				
				<div class="col col-xs-12 col-sm-8 form-group">
				  <label class="control-label" for="automobile-title">عنوان فایل<span class="required-field">*</span></label>
				  <input class="form-control" id="automobile-title" type="text"
				  		 placeholder="عنوان فایل" ng-model="item.title"
				  		 maxlength="100" required>
				</div>
				<div class="col col-xs-12 col-sm-4 form-group">
				  <label class="control-label" for="automobile-code">کد فایل<span class="required-field">*</span></label>
				  <input class="form-control" id="automobile-code" type="number"
				  		 minlength="1" maxlength="4" placeholder="کد فایل" ng-model="item.code" required				  		>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-brand">برند<span class="required-field">*</span></label>
				  <select class="form-control" id="automobile-brand" ng-model="item.automobile_brand"
				  			ng-options="automobileBrand.value for automobileBrand in automobileBrands"
				  			required>
		          </select>
				</div>
				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-type">نوع<span class="required-field">*</span></label>
				  <select class="form-control" id="automobile-type" ng-model="item.automobile_type"
				  			ng-options="automobileType.value for automobileType in automobileTypes | filter: {parent_id: item.automobile_brand.id}:true"
				  			required>
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="price">قیمت</label>
				  	<input class="form-control" id="price" type="number"
				  		minlength="1" maxlength="10" ng-model="item.price"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  	<label class="control-label" for="automobile-age">سال ساخت<span class="required-field">*</span></label>
				  	<select class="form-control" id="automobile-age" ng-model="item.created_year"
				  		required>
				  		<option ng-repeat="age in ages" value="{{age}}"> {{age}}</option>
		            
		          	</select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="automobile-color">رنگ</label>
				  <select class="form-control" id="automobile-color" ng-model="item.automobile_color"
				  			ng-options="automobileColor.value for automobileColor in automobileColors">
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="automobile-usage">کارکرد</label>
				  	<input class="form-control" id="automobile-usage" type="number"
				  		minlength="1" maxlength="6" ng-model="item.usage"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label class="control-label" for="automobile-tip">تیپ</label>
				  	<input class="form-control" id="automobile-tip" type="text"
				  		minlength="1" maxlength="20" ng-model="item.tip"
				  	>

				</div>

				<div class="col col-xs-12 form-group database-features">
					<label class="control-label">امکانات</label>
					<ul>
						<li ng-repeat="feature in automobileFeatures">
							<label for="automobile-feature-{{feature.id}}">{{feature.value}}</label>
							<input ng-model="item.automobile_features[feature.id]" id="automobile-feature-{{feature.id}}" type="checkbox" value="feature.value" />
						</li>
					</ul>

				</div>
				<div class="col col-xs-12 form-group">
					<label class="control-label" for="description">توضیحات</label>
					<textarea class="form-control" id="description" type="text"
						placeholder="توضیحات" ng-model="item.description" 
						rows="4" maxlength="1000">
					</textarea>
				</div>
			    
			</div>
			

			<hr/>
			<div class="row">

	            <div class="col-md-12" style="margin-bottom: 40px">
	                <h3>بارگذاری تصویر (پنج تصویر)
		                <button class="btn btn-info btn-sm" ng-click="uploadAlert(); $event.preventDefault();">
		                	انتخاب فایل
		                </button>
	                </h3>
	                <!-- <div class="progress" style="">
                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                    </div>
                    <hr ng-show="estate.photos"/>
                    <div class="row" ng-show="estate.photos">
                    	<div class="col col-xs-12 col-sm-6 col-md-3" ng-repeat="photo in estate.photos">
                    		<div class="image-thumb">
	                    		<img ng-src="{{photo.icon_absolute_path}}" />
	                    		<button class="thumbnail-remove btn btn-danger btn-xs" ng-click="removePhoto($index)"><div class="dk icon-remove"></div></button>
                    		</div>
                    	</div>
                    </div> -->
	                <!-- <table class="table">
	                    <thead>
	                        <tr>
	                            <th width="30%">نا‍م</th>
	                            <th width="20%" ng-show="uploader.isHTML5">اندازه</th>
	                            <th width="10%" ng-show="uploader.isHTML5"></th>
	                            <th width="10%">وضعیت</th>
	                            <th width="20%">عملیات</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr ng-repeat="item in uploader.queue">
	                            <td width="30%">
	                                <strong>{{ item.file.name }}</strong>
	                                <div ng-show="uploader.isHTML5" ng-thumb="{ file: item._file, height: 100 }"></div>
	                            </td>
	                            <td width="20%" ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
	                            <td width="10%" ng-show="uploader.isHTML5">
	                                <div class="progress" style="margin-bottom: 0;">
	                                    <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
	                                </div>
	                            </td>
	                            <td width="10%" class="text-center">
	                                <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
	                                <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
	                                <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
	                            </td>
	                            <td width="30%" nowrap>
	                                <button style="float: right;  margin-top: 3px; clear: both;" type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
	                                    <span class="glyphicon glyphicon-upload"></span> بارگذاری
	                                </button>
	                                <button style="float: right;  margin-top: 3px; clear: both;" type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
	                                    <span class="glyphicon glyphicon-ban-circle"></span> انصراف
	                                </button>
	                                <button style="float: right; margin-top: 3px; clear:both" type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
	                                    <span class="glyphicon glyphicon-trash"></span> حذف
	                                </button>
	                            </td>
	                        </tr>
	                    </tbody>
	                </table> -->

	                <!-- <div>
	                    <div>
	                        صف بارگذاری:
	                        <div class="progress" style="">
	                            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
	                        </div>
	                    </div>
	                    
	                    <button type="button" class="btn btn-success btn-s" ng-click="uploader.uploadAll()" ng-disabled="!uploader.getNotUploadedItems().length">
	                        <span class="glyphicon glyphicon-upload"></span> بارگذاری همه
	                    </button>
	                    <button type="button" class="btn btn-warning btn-s" ng-click="uploader.cancelAll()" ng-disabled="!uploader.isUploading">
	                        <span class="glyphicon glyphicon-ban-circle"></span> انصراف همه
	                    </button>
	                    <button type="button" class="btn btn-danger btn-s" ng-click="uploader.clearQueue()" ng-disabled="!uploader.queue.length">
	                        <span class="glyphicon glyphicon-trash"></span> حذف همه
	                    </button>
	                    <button ng-click="logUploader()">asd</button>
	                </div> -->

	            </div>

	        </div>

			
		</form>

	</div>
</div>