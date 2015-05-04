<div class="row top-row">
	<div class="col col-xs-9 right-col">
		<h4 ng-show="product.title" ng-bind="product.title" class="product-title">
			
		</h4>

		<div class="product-special-text" ng-show="product.special_text" ng-bind="product.special_text">
		</div>
		
		
	</div>
	<div class="col col-xs-3 left-col">
		<div ng-init="imageUrl = product.photos[0].icon_absolute_path ? product.photos[0].icon_absolute_path : null" 
			class="image-wrapper" 
			ng-style="(imageUrl) ? {'background-image': 'url('+imageUrl+')'} : null">
			<!-- <img ng-src="{{imageUrl}}" > -->
			<div ng-show="sortable" class="product-sort-buttons">
				<div class="" data-as-sortable-item-handle>
					<div class="dk icon-sort"></div>
			  	</div>
			  	<button ng-click="deleteProduct(group.id, product)" class="btn btn-xs btn-danger">
			  		<div class="dk icon-trash"></div>
			  	</button>
			</div>
		</div>
	</div>
	
</div>

<div class="row bottom-row">
	<div class="col col-xs-9 right-col">
		<div layout="row">
			<div class="product-price" ng-class="{'discounted' : product.discounted_price}" flex ng-show="product.price" ng-bind="product.price | currency:'':0">
			</div>
			<div class="product-discounted-price" flex ng-show="product.discounted_price" ng-bind="product.discounted_price">
			</div>
		</div>
	</div>
	<div class="col col-xs-3 left-col">
		کد: {{product.code}}
	</div>
</div>

<div ng-show="product.special_tag" class="product-special-tag" >
	<span ng-show="product.special_tag == 1" class="new">new</span>
	<span ng-show="product.special_tag == 2" class="special">special</span>
	<span ng-show="product.special_tag == 3" class="discount">discount</span>
	
</div>

