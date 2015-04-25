<ul data-as-sortable="dragControlListeners" data-ng-model="products[group.id]">
   <li class="" data-ng-repeat="product in products[group.id]" data-as-sortable-item>
		<div class="product-item">
			<div class="product-teaser" ng-click="selectProduct(product)" ng-class="{'clickable': !sortable}" ng-include="'customer/template/store-product.html'" ng-controller="StoreProductCtrl">
	   		</div>
   		</div>
   </li>
</ul>
