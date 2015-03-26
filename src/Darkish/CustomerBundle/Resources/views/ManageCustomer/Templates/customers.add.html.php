<form name="customerAdd">
<div class="btn-group">
    <button ui-sref="customers" type="button" class="btn btn-default" aria-label="Right Align">
        بازگشت
    </button>
    <button ng-disabled="!customerAdd.$valid" type="submit" ng-click="submit()" class="btn btn-success">ذخیره</button>

</div>
<h1>ایجاد مشتری جدید</h1>
<hr/>
    <div class="container">
        <div class="row">
            <div class="col col-md-4 right">
                
                <div class="form-group">
                    <label for="customerUsername">نام کاربری (پست الکترونیک)</label>
                    <input ng-model="customer.username" type="email" class="form-control" id="customerUsername" placeholder="نام کاربری">
                </div>
                <div class="form-group">
                    <label for="customerPassword">رمز عبور</label>
                    <input required="required" ng-pattern="/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/" name="customerPassword" ng-model="customer.newPassword" type="password" class="form-control" id="customerPassword" placeholder="رمز عبور">
                </div>
                <div class="form-group">
                    <label for="customerPasswordConfirm">تکرار رمز عبور</label>
                    <input required="required" name="customerPasswordConfirm" match="customer.newPassword" ng-model="customer.new_password_confirm" type="password" class="form-control" id="customerPasswordConfirm" placeholder="تکرار رمز عبور">
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
            <div class="col col-md-4 left">
                <div class="checkbox is-active">
                    <label>
                        فعال
                    </label>
                    <switch id="is-active" name="is_active" ng-model="customer.is_active" class="is-active-switch"></switch>
                </div>
                <div class="form-group">
                    <label for="customerAccessLevel">سطح دسترسی</label>
                    <div class="checkbox" ng-repeat="role in roles">
                        <label>
                            <input type="checkbox" checklist-model="customer.assistant_access" checklist-value="role.id"> {{role.name}}
                        </label>
                    </div>
                    
                </div>
                
            </div>
            <div class="col col-md-4 left">
                <div class="form-group">
                    <label for="exampleInputFile clearfix">تصویر کاربر</label>

                    <div class="row file-upload-row">
                        <div class="col col-md-2">
                            <label class="file-select btn btn-success">
                                انتخاب فایل
                                <input  type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                            </label>
                        </div>


                        <div class="col col-md-3">
                            <div class="progress" style="">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                            </div>
                        </div>
                        <div class="col col-md-1 upload-cancel">
                            <button ng-show="uploader.isUploading" ng-disabled="!RecordService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                                X
                            </button>
                        </div>
                        <div class="col col-md-3 message-box">
                            <span class="uploader-msg" ng-bind="uploader.msg">

                            </span>
                        </div>
                        <div class="col col-md-3 ">
                            <img class="customer-photo-thumb" ng-src="{{customer.photo.absolute_path}}" />
                        </div>


                    </div>
                </div>
                
                <div class="form-group">
                    <label for="customerFullName">نام و نام خانوادگی</label>
                    <input ng-model="customer.full_name" type="text" class="form-control" id="customerFullName" placeholder="نام و نام خانوادگی">
                </div>
                <div class="form-group">
                    <label for="customerPhoneOne">تلفن اول</label>
                    <input ng-model="customer.phone_one" type="text" class="form-control" id="customerPhoneOne" placeholder="تلفن اول">
                </div>
                <div class="form-group">
                    <label for="customerPhoneTwo">تلفن دوم</label>
                    <input ng-model="customer.phone_two" type="text" class="form-control" id="customerPhoneTwo" placeholder="تلفن دوم">
                </div>
                <div class="form-group">
                    <label for="customerPhoneThree">تلفن سوم</label>
                    <input ng-model="customer.phone_three" type="text" class="form-control" id="customerPhoneThree" placeholder="تلفن سوم">
                </div>
                <div class="form-group">
                    <label for="customerPhoneFour">تلفن چهارم</label>
                    <input ng-model="customer.phone_four" type="text" class="form-control" id="customerPhoneFour" placeholder="تلفن چهارن">
                </div>
            </div>
        </div>
    </div>
    
</form>