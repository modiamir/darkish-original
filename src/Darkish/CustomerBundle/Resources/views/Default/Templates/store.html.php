
<div class="store-page">
	<div class="row links-row">
		<div class="col-xs-12">
			<a class="btn btn-info" ui-sref="store.edit">ویرایش فروشگاه</a>
			<a class="btn btn-default" ui-sref="store.create">ایجاد محصول جدید</a>
		</div>
	</div>
	<div class="row main-row">
		<div class="col col-xs-12 col-sm-6 products-list">
			list of products
		</div>

		<div class="col col-xs-12 col-sm-6 child-states">
			<a ng-hide="state.current.name == 'store'" class="btn btn-primary btn-sm return-button" 
				ui-sref="store">بازگشت</a>
			<div ng-show="state.current.name == 'store'" class="well store-details">
				<img src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_banner.jpg') ?>" ng-src="{{storeData.market_banner.mobile_absolute_path}}" class="banner-image">
				<span class="store-description" ng-bind="storeData.market_description"></span>
				<label class="store-groups-label">گروه ها:</label>
				<ul class="store-groups">
					<li ng-repeat="group in storeData.market_groups">
						<span class="label label-success">{{group.name}}</span>
					</li>
				</ul>
				<label class="store-template-label">قالب:</label>
				<span class="store-template" ng-bind="storeData.market_template.title"></span>

			</div>
			<div ng-hide="state.current.name == 'store'" class="well" ui-view>
			</div>
		</div>
	</div>
</div>

