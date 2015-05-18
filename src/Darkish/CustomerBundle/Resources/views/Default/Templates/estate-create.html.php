<div class="database-create database-form">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'database'" class="return-button" 
			ui-sref="database">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		آیتم جدید
		<button ng-disabled="databasecreate.$invalid" ng-click="saveItem()" class="details-header-button btn btn-sm btn-primary">
			<span class="">ذخیره</span>
			<div class="dk icon-arrow-left"></div>
		</button>
	</div>
	<div class="database-create-estate details-inner well">
		<form name="databasecreate">
			<div class="row">
				<div class="col col-xs-12 col-sm-8 form-group">
				  <label class="control-label" for="estate-title">عنوان فایل <span class="required-field">*</span></label>
				  <input class="form-control" id="estate-title" type="text"
				  		 placeholder="عنوان فایل" ng-model="item.title"
				  		 maxlength="100" required>
				</div>
				<div class="col col-xs-12 col-sm-4 form-group">
				  <label class="control-label" for="estate-code">کد فایل<span class="required-field">*</span></label>
				  <input class="form-control" id="estate-code" type="number"
				  		 minlength="1" maxlength="4" placeholder="کد فایل" ng-model="item.code"
				  		required>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="estate-contract-type">نوع واگذاری<span class="required-field">*</span></label>
				  <select class="form-control" id="estate-contract-type" ng-model="item.contract_type"
				  			ng-options="contractType.value for contractType in contractTypes"
				  			required>
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  <label class="control-label" for="estate-type">نوع ملک<span class="required-field">*</span></label>
				  <select class="form-control" id="estate-type" ng-model="item.estate_type"
				  			ng-options="estateType.value for estateType in estateTypes"
				  			required>
		            
		          </select>
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
				  	<label ng-show="item.contract_type.id != 2" class="control-label" for="price">قیمت</label>
				  	<label ng-show="item.contract_type.id == 2" class="control-label" for="price">رهن</label>
				  	<input class="form-control" id="price" type="number"
				  		minlength="1" maxlength="12" ng-model="item.price"
				  	>

			  		<label ng-show="item.contract_type.id == 2" class="control-label" for="estate-code">اجاره</label>
				  	<input ng-show="item.contract_type.id == 2" class="form-control" id="estate-code" type="number"
				  		minlength="1" maxlength="12" ng-model="item.secondary_price"
				  	>


				</div>


				<div class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-dimension">متراژ</label>
					<input class="form-control" id="estate-dimension" type="number"
							 placeholder="متراژ" ng-model="item.dimension"
							 maxlength="5">
				</div>


				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-6 col-md-4 form-group">
				  	<label class="control-label" for="estate-num-of-rooms">تعداد اتاق</label>
				  	<select class="form-control" id="estate-num-of-rooms" ng-model="item.num_of_rooms">
		            	<option ng-repeat="key in [1,2,3,4,5,6,7,8,9,10]" value="{{key}}">{{key}}</option>
		          	</select>
				</div>


				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-floor">طبقه</label>
					<input class="form-control" id="estate-floor" type="number"
							 placeholder="طبقه" ng-model="item.floor"
							 maxlength="2">
				</div>

				<div class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-region">منطقه/بازار</label>
					<input class="form-control" id="estate-region" type="text"
							 placeholder="منطقه/بازار" ng-model="item.region"
							 maxlength="20">
				</div>

				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 col-sm-4 form-group">
					<label class="control-label" for="estate-age">سن بنا</label>
					<input class="form-control" id="estate-age" type="number"
							 placeholder="سن بنا" ng-model="item.age"
							 maxlength="2">
				</div>

				<div ng-hide="item.estate_type.id == 8" class="col col-xs-12 form-group database-features">
					<label class="control-label">امکانات</label>
					<ul>
						<li ng-repeat="feature in estateFeatures">
							<label for="estate-feature-{{feature.id}}">{{feature.value}}</label>
							<input ng-model="item.estate_features[feature.id]" id="estate-feature-{{feature.id}}" type="checkbox" value="feature.value" />
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