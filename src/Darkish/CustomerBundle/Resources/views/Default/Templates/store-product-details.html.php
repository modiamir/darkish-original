<div class="store-product-details">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'store'" class="return-button" 
			ui-sref="store">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		<span class="details-header-title">عنوان محصول</span>
		<button ng-disabled="productcreate.$invalid" ui-sref="store.editproduct({pid:product.id})" class="details-header-button btn btn-sm btn-primary">
			<span class="hidden-xs">ویرایش</span>
			<div class="dk icon-arrow-left"></div>
		</button>
	</div>
	<div class="store-create-product details-inner well">
		<h3 ng-show="product.title" ng-bind="product.title">
		</h3>
		<h5 ng-show="product.group">
			<label>گروه:</label>
			<span ng-bind="product.group.name"></span>
		</h5>
		<div class="product-special-text" ng-show="product.special_text" ng-bind="product.special_text">
		</div>
		<br/>
		<h3 ng-show="product.photos.length > 0">
			تصاویر
		</h3>
		<hr ng-show="product.photos.length > 0" />
		<ul ng-show="product.photos.length > 0">
		  <li ng-repeat="image in product.photos">
		    <a ng-click="openLightboxModal($index)">
		      <img ng-src="{{image.icon_absolute_path}}" class="img-thumbnail" alt="">
		    </a>
		  </li>
		</ul>

	</div>
</div>