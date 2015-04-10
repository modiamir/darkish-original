
<div class="row store-page page">
	<div class="col col-xs-12 col-sm-5 products-list master">
		<div class="well master-buttons"> 
			<a ng-disabled="state.current.name != 'store'" class="btn btn-info" ui-sref="store.edit">ویرایش فروشگاه</a>
			<a ng-disabled="state.current.name != 'store'" class="btn btn-default" ui-sref="store.create">ایجاد محصول جدید</a>
		</div>
		<div class="master-inner well">
			list of products
		</div>
		
	</div>

	<div class="col col-xs-12 col-sm-7 details child-states">
		<div ng-show="state.current.name == 'store'" class="details-header" id="details-header">
			<button ng-disabled="state.current.name == 'store'" class="return-button" 
				ui-sref="store">
				<div class="icon icon-arrow-right"></div>
			</button>
			<span class="details-header-title">مشخصات فروشگاه</span>
			<!-- <button class="details-header-button btn btn-sm btn-primary">
				مشخصات فروشگاه
			</button> -->
		</div>
		<div ng-show="state.current.name == 'store'" class="well store-details details-inner">
			<label>توضیحات</label>
			<span class="store-description" ng-bind="storeData.market_description"></span>
			<hr/>
			<label>بنر فروشگاه</label>
			<img src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_banner.jpg') ?>" ng-src="{{storeData.market_banner.mobile_absolute_path}}" class="banner-image">
			<hr/>
			<label class="store-template-label">قالب:</label>
			<span class="store-template" ng-bind="storeData.market_template.title"></span>
			<hr/>
			<label class="store-groups-label">گروه ها:</label>
			<ul class="list-group store-groups">
				<li ng-repeat="group in storeData.market_groups" class="list-group-item">
					<span class="">{{group.name}}</span>
				</li>
			</ul>

		</div>
		<div ui-view>
		</div>
	</div>
</div>

