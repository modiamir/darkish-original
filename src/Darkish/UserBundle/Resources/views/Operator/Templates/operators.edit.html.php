<form name="operatorEdit">
<!--<a ui-sref="operators" class="btn btn-default btn-xs">بازگشت</a>-->
<div class="btn-group">
    <button ui-sref="operators" type="button" class="btn btn-default" aria-label="Right Align">
        بازگشت
    </button>
    <button ng-disabled="!operatorEdit.$valid" type="submit" ng-click="submit()" class="btn btn-success">ذخیره</button>

</div>
<h1>ویرایش
{{operator.username}}</h1>
<hr/>

    <div class="container">
        <div class="row">
            
        </div>
        <div class="row">
            <div class="col col-md-4 right">
                <div class="form-group">
                    <label for="operatorUsername">نام کاربری</label>
                    <input ng-disabled="true" ng-model="operator.username" type="text" class="form-control" id="operatorUsername" placeholder="نام کاربری">
                </div>
                
                <div class="form-group">
                    <label for="operatorPassword">رمز عبور</label>
                    <input ng-pattern="/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/" name="operatorPassword" ng-model="operator.newPassword" type="password" class="form-control" id="operatorPassword" placeholder="رمز عبور">
                </div>
                <div class="form-group">
                    <label for="operatorPasswordConfirm">تکرار رمز عبور</label>
                    <input  name="operatorPasswordConfirm" match="operator.newPassword" ng-model="operator.new_password_confirm" type="password" class="form-control" id="operatorPasswordConfirm" placeholder="تکرار رمز عبور">
                    <div ng-show="operatorEdit.operatorPasswordConfirm.$error.match">رمز های وارد شده باهم مطابقت ندارد</div>
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
                <div class="form-group">
                    <label for="operatorEmail">پست الکترونیک</label>
                    <input dir="ltr" ng-model="operator.email" ng-disabled="true" type="email" class="form-control" id="operatorEmail" placeholder="پست الکترونیک">
                </div>
                
            </div>
            <div class="col col-md-4 left">
                <div ng-show="operator.id !=1" class="checkbox is-active">
                    <label>
                        فعال
                    </label>
                    
                    <switch id="is-active" name="is_active" ng-model="operator.is_active" class="is-active-switch"></switch>
                    
                </div>
                <div class="form-group">
                    <label for="operatorAccessLevel">سطح دسترسی</label>
                    <div class="checkbox" ng-repeat="level in ValuesService.accessLevels">
                        <label>
                            <input ng-disabled="operator.id == 1" type="checkbox" checklist-model="operator.access_level" checklist-value="level.value"> {{level.label}}
                        </label>
                    </div>
                    
                </div>

                <div class="form-group">
                    <label for="operatorRoles">نقش ها</label>
                    <select ng-disabled="operator.id == 1" multiple ng-model="operator.roles" class="form-control" id="operatorRoles" 
                             ng-options="role.id as role.name for role in ValuesService.roles">
                        <!--            <option ng-repeat="role in ValuesService.roles" value="{{role.id}}">
                                        {{role.name}}
                                    </option>-->
                    </select>
                </div>
                <div class="form-group">
                    <label for="operatorCustomer">مشتری درکیش</label>
                    <select  ng-model="operator.customer" class="form-control" id="operatorCustomer" 
                             ng-options="customer as customer.full_name for customer in darkishCustomers">
                        <!--            <option ng-repeat="role in ValuesService.roles" value="{{role.id}}">
                                        {{role.name}}
                                    </option>-->
                    </select>
                    <button class="btn btn-sm btn-danger" ng-click="operator.customer = {}"> حذف مشتری</button>
                </div>
                <div class="form-group">
                    <label for="operatorSecondaryEmail">پست الکترونیک ثانویه</label>
                    <input dir="ltr" ng-model="operator.secondary_mail" type="email" class="form-control" id="operatorSecondaryEmail" placeholder="پست الکترونیک ثانویه">
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
                            <img class="operator-photo-thumb" ng-src="{{operator.photo.absolute_path}}" />
                        </div>


                    </div>
                </div>
                <div class="form-group">
                    <label for="operatorFirstName">نام</label>
                    <input ng-model="operator.first_name" type="text" class="form-control" id="operatorFirstName" placeholder="نام">
                </div>
                <div class="form-group">
                    <label for="operatorLastName">نام خانوادگی</label>
                    <input ng-model="operator.last_name" type="text" class="form-control" id="operatorLastName" placeholder="نام خانوادگی">
                </div>
                <div class="form-group">
                    <label for="operatorPhone">تلفن</label>
                    <input ng-model="operator.phone" type="text" class="form-control" id="operatorPhone" placeholder="تلفن">
                </div>
                <div class="form-group">
                    <label for="operatorMobile">موبایل</label>
                    <input ng-model="operator.mobile" type="text" class="form-control" id="operatorMobile" placeholder="موبایل">
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
</form>