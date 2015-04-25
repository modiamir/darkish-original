
<div class="row store-page page">
	<div ng-hide="isXSmall() && state.current.name != 'store'" class="col col-xs-12 col-sm-5 col-md-4 col-lg-4 products-list master">
		<div class="well master-buttons" ng-class="{'fixed': isXSmall()}"> 
			<div class="btn-group btn-group-justified">
			  <a ng-disabled="state.current.name != 'store'" class="btn btn-info" ui-sref="store.details">فروشگاه</a>
			  <a ng-show="!sortable" ng-disabled="state.current.name != 'store'" class="btn btn-default" ng-click="sortable= !sortable">ویرایش</a>
			  <a ng-show="sortable" ng-disabled="state.current.name != 'store'" class="btn btn-default" ng-click="saveSort()">اتمام</a>
			  <a ng-disabled="state.current.name != 'store'" class="btn btn-default" ui-sref="store.create">محصول جدید</a>
			</div>
		</div>
		<div class="master-inner well" ng-class="{'scrollable': !isXSmall()}">
			<div class="products-list">
				<!-- <div class="accordion">
					<div class="accordion-inner">
						<ang-accordion>
						    <collapsible-item ng-repeat="group in storeData.market_groups" title='{{group.name}}'>
						        <div class="group-products-wrapper" ng-controller="StoreGroupProductsCtrl" ng-include="'customer/template/store-group-products.html'" scope="" onload="">
						        </div>
						    </collapsible-item>
						</ang-accordion>
					</div>
				</div> -->

				<div class="accordion-wrapper">
					<ul class="accordion-list" ng-init="currentGroup = 0">
						<li class="collapsible" ng-repeat="group in storeData.market_groups | orderBy:'sort'">
							<div ng-class="{'active': group.id == currentGroup}" ng-click="currentGroup = (currentGroup == group.id) ? 0 : group.id" class="header">
								<div ng-hide="group.id == currentGroup" class="dk icon-add"></div>
								<div ng-show="group.id == currentGroup" class="dk icon-remove"></div>
								{{group.name}}
							</div>
							<div ng-show="group.id == currentGroup" class="body">
								<div class="group-products-wrapper" ng-controller="StoreGroupProductsCtrl" ng-include="'customer/template/store-group-products.html'" scope="" onload="">
						        </div>

							</div>
						</li>
					</ul>
				</div>
								 
			</div>

		</div>
		
	</div>

	<div class="col col-xs-12 col-sm-7  col-md-8 col-lg-8 details child-states">
		
		<div ui-view>
		</div>
	</div>
</div>

