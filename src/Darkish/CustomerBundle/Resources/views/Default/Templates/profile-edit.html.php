    <h2>ویرایش پروفایل</h2>
  	<hr>
	<div class="row profile-edit">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img width="130" src="http://localhost/n-darkish/web/bundles/darkishcustomer/images/default_profile.jpg" ng-src="{{editinguser.photo.icon_absolute_path}}" class="avatar img-circle" alt="avatar">
          <label class="file-select btn btn-success">
              تصویر دیگری آپلود کنید...
              <input  type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
          </label>
          
        </div>
        <div class="row file-upload-row">
            <div ng-show="uploader.isUploading" class="col col-md-8 col-md-offset-2">
                <div class="progress" style="">
                    <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                </div>
            </div>
            <div ng-show="uploader.isUploading" class="col col-md-8 col-md-offset-2 upload-cancel">
                <button  ng-disabled="!RecordService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                    X
                </button>
            </div>
            <div class="col col-md-8 col-md-offset-2 message-box">
                <span class="uploader-msg" ng-bind="uploader.msg">

                </span>
            </div>


        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        
        
        <form class="form-horizontal" name="profileeditform" role="form">
          <div class="form-group">
            <label for="profile-fullname" class="col-lg-2 control-label">نام و نام خانوادگی:</label>
            <div class="col-lg-8">
              <input id="profile-fullname" class="form-control" type="text" ng-model="editinguser.full_name">
            </div>
          </div>
          <div class="form-group">
            <label for="profile-username" class="col-lg-2 control-label">نام کاربری:</label>
            <div class="col-lg-8">
              <input id="profile-username" class="form-control" type="text" ng-model="editinguser.username">
            </div>
          </div>
          <div class="form-group">
            <label for="profile-password" class="col-md-2 control-label">رمز عبور:</label>
            <div class="col-md-8">
              <input id="profile-password" ng-pattern="/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/" class="form-control" type="password" ng-model="editinguser.password" placeholder="رمز عبور">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
              <div ng-show="customerEdit.customerPasswordConfirm.$error.match">رمز های وارد شده باهم مطابقت ندارد</div>
              <ul>
                  <li>
                      رمز عبور باید حداقل دارای یک حرف باشد.
                  </li>
                  <li>
                      رمز عبور باید حداقل دارای یک  عدد باشد.
                  </li>
                  <li>
                      رمز عبور باید حداقل از 6 کاراکتر تشکیل شده باشد.
                  </li>
              </ul>
            </div>
              
          </div>
          
          
          <div class="form-group">
            <label for="profile-password-confirm" class="col-md-2 control-label">تکرار رمز عبور:</label>
            <div class="col-md-8">
              <input id="profile-password-confirm" match="editinguser.password" class="form-control" type="password" ng-model="editinguser.password_confirm" placeholder="تکرار رمز عبور">
            </div>
          </div>
          
          <div class="form-group">
            <label for="profile-phone-first" class="col-lg-2 control-label">تلفن اول:</label>
            <div class="col-lg-8">
              <input id="profile-phone-first" class="form-control" type="text" ng-model="editinguser.phone_one">
            </div>
          </div>

          <div class="form-group">
            <label for="profile-phone-second" class="col-lg-2 control-label">تلفن دوم:</label>
            <div class="col-lg-8">
              <input id="profile-phone-second" class="form-control" type="text" ng-model="editinguser.phone_two">
            </div>
          </div>

          <div class="form-group">
            <label for="profile-phone-third" class="col-lg-2 control-label">تلفن سوم:</label>
            <div class="col-lg-8">
              <input id="profile-phone-third" class="form-control" type="text" ng-model="editinguser.phone_three">
            </div>
          </div>

          <div class="form-group">
            <label for="profile-phone-fouth" class="col-lg-2 control-label">تلفن چهارم:</label>
            <div class="col-lg-8">
              <input id="profile-phone-fouth" class="form-control" type="text" ng-model="editinguser.phone_four">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label"></label>
            <div class="col-md-8">
              <input type="button" class="btn btn-primary" value="ذخیره"
                     ng-click="saveProfile(editinguser)"
                     ng-disabled="profileeditform.$invalid || isUnchanged(editinguser)"
              >
              <input type="reset" class="btn btn-default" value="انصراف"
                     ng-click="state.go('profile')"

              >
            </div>
          </div>
        </form>
      </div>
  </div>
<hr>