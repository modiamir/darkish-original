

<div class="row profile-edit-page page">
    <div class="col col-xs-12 details">
        <div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">

            <button class="return-button" ui-sref="profile" href="#/store" aria-disabled="false">
                <div class="dk icon-arrow-right"></div>
                <span class="hidden-xs">بازگشت</span>
            </button>

            <button ng-click="saveProfile(editinguser)"
                    ng-disabled="profileeditform.$invalid || isUnchanged(editinguser)" class="details-header-button btn btn-sm btn-primary">
                <span class="">ذخیره</span>
                <div class="dk icon-arrow-left"></div>
            </button>


        </div>
        <div class="store-create-product details-inner well">

<h2 class="page-title">ویرایش پروفایل</h2>
  	<hr>

    <div ng-show="uploading"  class="row">
        <div class="col col-xs-12">
            <div ng-show="myImage" class="cropArea" style="overflow: hidden;
                                        width: 500px;
                                        height: 350px;
                                        margin: auto;
                                        margin-bottom: 40px;">
                <img-crop on-change="onChangeCrop()" change-on-fly="true" result-image-format="image/jpeg" image="myImage" result-image="myCroppedImage"></img-crop>
            </div>

            <button class="btn btn-info" ng-show="myImage" ng-click="logFile()">
                بارگزاری
            </button>
        </div>
    </div>

	<div ng-hide="uploading"  class="row profile-edit">
      <!-- left column -->
      <div class="col  col-xs-12 col-sm-3">
        <div class="text-center">

          <img ng-show="myImage" width="130" src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>"
               ng-src="{{myCroppedImage}}"
               class="avatar img-circle" alt="avatar">
        <img ng-hide="myImage" width="130" src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>"
             ng-src="{{editinguser.photo.icon_absolute_path}}"
             class="avatar img-circle" alt="avatar">
          <label class="file-select btn btn-success">
              تصویر دیگری آپلود کنید...
<!--              <input ng-init="photo = editinguser.photo"  type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>-->
              <input type="file" id="fileInput" style="visibility: hidden;display: none" />
          </label>
            <br/>
            <br/>
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
      <div class="col col-xs-12 col-sm-9 personal-info">
        
        
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
              <input ng-disabled="true"  id="profile-username" class="form-control" type="text" ng-model="editinguser.username">
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

        </form>
      </div>
  </div>
<hr>
        </div>
    </div>
</div>