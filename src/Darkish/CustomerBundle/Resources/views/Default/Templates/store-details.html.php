<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
	<button ng-disabled="state.current.name == 'store'" class="return-button" 
		ui-sref="store">
		<div class="dk icon-arrow-right"></div>
	</button>
	مشخصات فروشگاه
	<button ui-sref="store.edit" class="details-header-button btn btn-sm btn-primary">
		<div class="dk icon-edit"></div>ویرایش 
	</button>
</div>
<div class="well store-details details-inner">
	<label>توضیحات</label>
	<span class="store-description" ng-bind="storeData.market_description"></span>
	<hr/>
	<label>بنر فروشگاه</label>
	<img src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_banner.jpg') ?>" ng-src="{{storeData.market_banner.mobile_absolute_path}}" class="banner-image">
	<hr/>
	<label class="store-template-label">قالب:</label>
	<span class="store-template" ng-bind="storeData.market_template.title"></span>
	<hr/>
	<label class="store-online-order-label">امکان سفارش آنلاین:</label>
	<span class="store-online-order" ng-bind="storeData.market_online_order == true ?'دارد':'ندارد'"></span>
	<hr/>
	<label><h3>گروه ها</h3></label>

	<div class="btn-group btn-group-justified product-details-groups" ng-init="groupEdit = 0; groupAdd = 0" >
		<!-- <a class="btn btn-info" disabled="disabled">گروه ها</a> -->
		<a ng-disabled="groupAdd" ng-hide="groupEdit" ng-click="groupEdit = 1" class="btn btn-info edit-groups"><div class="dk icon-edit"></div>ویرایش</a>
		<a ng-disabled="groupAdd" ng-show="groupEdit" ng-click="finish()" class="btn btn-info finish-edit-groups"><div class="dk icon-verify-small"></div>اتمام</a>
		<a ng-disabled="groupEdit || groupAdd" ng-click="groupAdd = 1" class="btn btn-info add-group"><div class="dk icon-add"></div>گروه جدید</a>
	</div>
	<div ng-show="groupAdd == 1" class="input-group group-add input-group-sm">
      	<span class="input-group-btn">
        	<button ng-click="groupAdd = 0; addingGroup=''" class="btn btn-warning" type="button">انصراف</button>
      	</span>
      	<input type="text" class="form-control" ng-model="addingGroup" placeholder="نام گروه">
      	<span class="input-group-btn">
        	<button class="btn btn-success" ng-disabled="!addingGroup || addingGroup == ' ' " ng-click="addGroup()" type="button">افزودن</button>
      	</span>
    </div>
    <ul id="board" style="position: relative;" class="store-groups" data-as-sortable="dragControlListeners" ng-model="tempGroups">
       <li data-ng-repeat="item in tempGroups" data-as-sortable-item>
          {{item.name}}
          <div ng-show="groupEdit" class="group-sort-buttons ">
          	<div data-as-sortable-item-handle>
          		<div class="dk icon-sort"></div>
          	</div>
          	<button class="btn btn-xs btn-danger" ng-click="deleteGroup($index)">
      	  		<div class="dk icon-trash"></div>
      	  	</button>
          </div>
       </li>
    </ul>

</div>