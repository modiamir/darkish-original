<div class="btn-group">
    <!-- <button ui-sref="add" class="btn btn-info">جدید</button> -->
</div>
<h2>لیست مشتری ها </h2>
<hr/>

<div class="container">
    <div class="row">
        <div class="col col-xs-3">
            <div class="form-group">
                <label for="exampleInputEmail1">جستجوی رکورد بر اساس شماره رکورد</label>
                <angucomplete-alt id="records-by-id"
                    placeholder="شماره رکورد"
                    pause="400"
                    minlength="1"
                    selected-object="foundById"
                    remote-url="ajax/find_records/recordNumber/"
                    remote-url-data-field="results"
                    title-field="record_number,title"
                    description-field="sub_title"
                    match-class="highlight"
                    text-searching="در حال جستجو..."
                    text-no-results="موردی یافت نشد!"
                    input-class="form-control form-control-small"/>
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">جستجوی رکورد بر اساس عنوان </label>
                <angucomplete-alt id="records-by-name"
                    placeholder="عنوان رکورد"
                    pause="400"
                    minlength="1"
                    selected-object="foundByTitle"
                    remote-url="ajax/find_records/title/"
                    remote-url-data-field="results"
                    title-field="record_number,title"
                    description-field="sub_title"
                    match-class="highlight"
                    text-searching="در حال جستجو..."
                    text-no-results="موردی یافت نشد!"
                    input-class="form-control form-control-small"/>
            </div>
            
            
        </div>
        <div class="col col-xs-9">
            <h3 ng-show="shared.currentRecord.id > 0">
                مشتری های مربوط به 
                <span class="">«{{shared.currentRecord.title}}»</span>
            </h3>
            <hr ng-show="shared.currentRecord.id > 0" />
            
            <h4 ng-show="shared.currentRecord.id > 0">
                مدیر
                <button type="button" class="btn btn-primary btn-xs" ng-disabled="owner.id" ng-click="add('owner', shared.currentRecord.id)">ایجاد مدیر</button>
            </h4>
            <hr ng-show="shared.currentRecord.id > 0"/>
            <table class="customers-table table table-striped">
                <thead ng-hide="isLoading || shared.currentRecord.id <= 0">
                    <tr class="row">
                        <th class="col col-xs-1" >شناسه</th>
                        <th class="col col-xs-4"  >نام کاربری (پست الکترونیکی)</th>
                        <th class="col col-xs-4">رکورد</th>
                        <th class="col col-xs-1">فعال</th>
                        <th class="col col-xs-2">عملیات</th>
                    </tr>

                </thead>
                <tbody ng-hide="isLoading || shared.currentRecord.id <= 0 || !owner.id">
                    <tr ng-dblclick="editCustomer(owner)"   class="row">
                        <td class="col col-xs-1">{{owner.id}}</td>
                        <td class="col col-xs-4">{{owner.username}}</td>
                        <td class="col col-xs-4">
                            {{owner.record.title}}
                        </td>
                        <td class="col col-xs-1">
                            <span ng-show="owner.is_active"><i class="fa fa-check-circle" style="color: #64bd63;font-size: 30px;"></i></span>
                            <span ng-hide="owner.is_active"><i class="fa fa-times-circle" style="color: rgb(255, 104, 104);font-size: 30px;"></i></span>
                        </td>
                        <td class="col col-xs-2">
                            <button type="button" ng-click="$event.stopPropagation();" ui-sref="edit({ id: owner.id })" class="btn btn-sm btn-info">
                                <i class="glyphicon glyphicon-edit">
                                </i>
                            </button>
                            <button type="button" ng-click="delete(owner, -1); $event.stopPropagation();" class="btn btn-sm btn-danger">
                                <i class="glyphicon glyphicon-remove-circle">
                                </i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tbody ng-show="shared.currentRecord.id > 0 && !owner.id">
                    <tr class="row">
                        <td colspan="5" class="col col-xs-12" style="text-align: center">
                            برای رکورد 
                            <span class="">«{{shared.currentRecord.title}}»</span>
                            هیچ مدیری یافت نشد.
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <h4 ng-show="shared.currentRecord.id > 0">
                دستیاران
                <button type="button" class="btn btn-primary btn-xs" ng-click="add('assistant', shared.currentRecord.id)">افزودن دستیار</button>
            </h4>
            <hr ng-show="shared.currentRecord.id > 0"/>
            <table st-pipe="refresh" st-table="displayedCustomers" st-safe-src="customers"  class="customers-table table table-striped">
                <thead>
                    <tr class="row">
                        <th class="col col-xs-1" st-sort="id" >شناسه</th>
                        <th class="col col-xs-4" st-sort="username" >نام کاربری (پست الکترونیکی)</th>
                        <th class="col col-xs-4">رکورد</th>
                        <th class="col col-xs-1">فعال</th>
                        <th class="col col-xs-2">عملیات</th>
                    </tr>

                </thead>
                <tbody ng-show="isLoading">
                    <tr class="row">
                        <td class="col col-xs-12" colspan="5" style="text-align: center">
                            <i class="fa fa-spinner fa-pulse"></i>
                        </td>
                    </tr>
                </tbody>
                <tbody ng-hide="isLoading || shared.currentRecord.id <= 0">
                    <tr ng-dblclick="editCustomer(customer)" st-select-row="customer" st-select-mode="single" ng-repeat="customer in displayedCustomers" class="row">
                        <td class="col col-xs-1">{{customer.id}}</td>
                        <td class="col col-xs-4">{{customer.username}}</td>
                        <td class="col col-xs-4">
                            {{customer.record.title}}
                        </td>
                        <td class="col col-xs-1">
                            <!--<span ng-hide="customer.id == 1" ng-click="toggleIsActive(customer);$event.stopPropagation()"><switch id="enabled" name="enabled" ng-model="customer.is_active" class="is-active-switch"></switch></span>-->
                            <span ng-show="customer.is_active"><i class="fa fa-check-circle" style="color: #64bd63;font-size: 30px;"></i></span>
                            <span ng-hide="customer.is_active"><i class="fa fa-times-circle" style="color: rgb(255, 104, 104);font-size: 30px;"></i></span>
                        </td>
                        <td class="col col-xs-2">
                            <button type="button" ng-click="$event.stopPropagation();" ui-sref="edit({ id: customer.id })" class="btn btn-sm btn-info">
                                <i class="glyphicon glyphicon-edit">
                                </i>
                            </button>
                            <button type="button" ng-click="delete(customer, $index); $event.stopPropagation();" class="btn btn-sm btn-danger">
                                <i class="glyphicon glyphicon-remove-circle">
                                </i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tbody ng-show="shared.currentRecord.id <= 0 ">
                    <tr class="row">
                        <td colspan="5" class="col col-xs-12" style="text-align: center">
                            لطفا از قسمت راست یک رکورد معتبر انتخاب کنید.
                        </td>
                    </tr>
                </tbody>
                <tbody ng-show="shared.currentRecord.id > 0 && displayedCustomers.length == 0">
                    <tr class="row">
                        <td colspan="5" class="col col-xs-12" style="text-align: center">
                            برای رکورد 
                            <span class="">«{{shared.currentRecord.title}}»</span>
                            هیچ دستیاری یافت نشد.
                        </td>
                    </tr>
                </tbody>
                <tfoot ng-show="shared.currentRecord.id > 0">
                    <tr>
                        <td colspan="5" class="text-center" >
                            <div st-pagination="" st-items-by-page="itemsByPage" "></div>
                        </td>
                    </tr>
                    
                </tfoot>
            </table>
        </div>
    </div>
</div>
