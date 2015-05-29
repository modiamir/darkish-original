<div class="database-create database-form">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'user'" class="return-button" 
			ui-sref="user">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		دستیار جدید
		<button ng-disabled="databasecreate.$invalid" ng-click="saveUser()" class="details-header-button btn btn-sm btn-primary">
			<span class="">ذخیره</span>
			<div class="dk icon-arrow-left"></div>
		</button>
	</div>
	<div class="database-create-automobile details-inner well">
		<form name="databasecreate">
			<div class="row">
				
				<div class="col col-xs-12 col-sm-6 form-group">
				  <label class="control-label" for="user-name">نام کاربری<span class="required-field">*</span></label>
				  <input class="form-control" id="user-name" type="text"
				  		 placeholder="نام کاربری" ng-model="newUser.username"
				  		 maxlength="255" required>
				</div>
				<div class="col col-xs-12 col-sm-4 form-group">
				  <label class="control-label" for="full-name">نام و نام خانوادگی<span class="required-field">*</span></label>
				  <input class="form-control" id="full-name" type="text"
				  		 maxlength="255" placeholder="نام و نام خانوادگی" ng-model="newUser.full_name" required				  		>
				</div>

				<div class="col col-xs-12 col-sm-2 form-group">
					<label class="control-label">وضعیت</label>
					<button type="button" class="btn btn-primary" ng-class="{'btn-success': newUser.is_active, 'btn-danger': !newUser.is_active}" ng-model="newUser.is_active" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
				       	{{(newUser.is_active) ? 'فعال' : 'غیر فعال'}}
				    </button>
				</div>

				<div class="col col-xs-12 col-sm-6 col-md-6 form-group">
				  <label class="control-label" for="password">رمز عبور<span class="required-field">*</span></label>
				  <input ng-pattern="/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/" class="form-control" id="password" type="password"
				  		 maxlength="255" placeholder="رمز عبور" ng-model="newUser.new_password" required				  		>
				</div>
				
				<div class="col col-xs-12 col-sm-6 col-md-6 form-group">
				  <label class="control-label" for="password-confirm">تایید رمز عبور<span class="required-field">*</span></label>
				  <input match="newUser.new_password" class="form-control" id="password-confirm" type="password"
				  		 maxlength="255" placeholder="رمز عبور" ng-model="newUser.new_password_confirm" required>
				</div>

				<div class="col col-xs-12 col-sm-6 form-group">
				  	<label class="control-label" for="phone-one">تلفن یک</label>
				  	<input class="form-control" id="phone-one" type="number"
				  		minlength="1" maxlength="10" ng-model="newUser.phone_one"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-6 form-group">
				  	<label class="control-label" for="phone-two">تلفن دو</label>
				  	<input class="form-control" id="phone-two" type="number"
				  		minlength="1" maxlength="10" ng-model="newUser.phone_two"
				  	>
			 	</div>

			  	<div class="col col-xs-12 col-sm-6 form-group">
				  	<label class="control-label" for="phone-three">تلفن دو</label>
				  	<input class="form-control" id="phone-three" type="number"
				  		minlength="1" maxlength="10" ng-model="newUser.phone_three"
				  	>

				</div>

				<div class="col col-xs-12 col-sm-6 form-group">
				  	<label class="control-label" for="phone-four">تلفن دو</label>
				  	<input class="form-control" id="phone-four" type="number"
				  		minlength="1" maxlength="10" ng-model="newUser.phone_four"
				  	>
			  	</div>
				


				<div class="col col-xs-12 col-sm-6 form-group user-accesses">
					<label class="control-label">دسترسی ها</label>
					<ul>
						<li ng-repeat="access in accesses">
							<label for="user-access-{{access.id}}">{{access.name}}</label>
							<input ng-model="newUser.assistant_access[access.id]" id="user-access-{{access.id}}" type="checkbox" value="access.name" />
						</li>
					</ul>

				</div>

				<div class="col col-xs-12 col-sm-6 form-group user-photo">
					<label class="control-label">تصویر پروفایل</label>
					<label ng-disabled="newUser.photo" class="btn btn-info btn-sm">
						انتخاب فایل
						<input type="file" ng-show="false" nv-file-select="" uploader="uploader" multiple  /><br/>
					</label>
					<div class="progress" style="">
                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                    </div>
                    <div ng-show="newUser.photo" class="image-thumb">
                		<img ng-src="{{newUser.photo.icon_absolute_path}}" />
                		<button class="thumbnail-remove btn btn-danger btn-xs" ng-click="newUser.photo = null; $event.preventDefault()"><div class="dk icon-remove"></div></button>
            		</div>
				</div>
				
			    
			</div>
			

			
		</form>

	</div>
</div>