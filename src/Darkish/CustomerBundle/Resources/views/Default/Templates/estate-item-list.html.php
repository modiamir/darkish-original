<div class="row top-row">
	<div class="col col-xs-8 right-col">
		<span class="item-contract-type" ng-bind="item.contract_type.value"></span>
		<span class="item-estate-type" ng-bind="item.estate_type.value"></span>
		<span class="customer-name" ng-bind="user.full_name"></span>
	</div>
	<div class="col col-xs-4 left-col">
		<span ng-show="item.code" class="item-code">کد {{item.code}}</span>
	</div>
	
</div>
<div class="row middle-row">

	<div class="col col-xs-8 right-col">
		<span class="item-description" ng-bind="item.description | limitTo:50">
		</span>
		<span ng-show="item.region" class="item-region" ng-bind="item.region"></span>
	</div>

	<div class="col col-xs-4 left-col">
		<div ng-init="imageUrl = item.photos[0].icon_absolute_path ? item.photos[0].icon_absolute_path : null" 
			class="image-wrapper estate-image"
			ng-style="(imageUrl) ? {'background-image': 'url('+imageUrl+')'} : null">
		</div>
		<div class="edit-buttons" ng-show="editmode">
			<button class="btn btn-danger remove-button" ng-click="deleteItem(item)"><div class="dk icon-trash"></div></button>
			<button ng-show="item.status" class="btn btn-warning disable-button" ng-click="disableItem(item)"><div class="dk icon-block"></div></button>
			<button ng-hide="item.status" class="btn btn-info enable-button" ng-click="enableItem(item)" ><div class="dk icon-verify-small"></button>
		</div>
	</div>





</div>
<div class="row footer-row" ng-show="item.dimension || item.num_of_rooms || item-floor || item.age || item.estate_features.indexOf('1') > -1">
	<div class="col col-xs-8 right-col">
		<span ng-show="item.dimension" class="item-dimension" ng-bind="item.dimension + ' متر'"></span>
		<span ng-show="item.dimension && item.num_of_rooms">-</span>
		<span ng-show="item.num_of_rooms" class="item-num-of-rooms" ng-bind="item.num_of_rooms + ' خواب'"></span>
		<span ng-show="(item.dimension || item.num_of_rooms) && item.floor">-</span>
		<span ng-show="item.floor" class="item-floor" ng-bind="'طبقه ' + item.num_of_rooms"></span>
	</div>
	<div class="col col-xs-4 left-col">
		<span ng-show="item.age" class="item-age" ng-bind="item.age + ' ساله'"></span>
		<span ng-show="item.age && item.estate_features.indexOf('1') > -1">-</span>
		<span ng-show="item.estate_features.indexOf('1') > -1">مبله</span>
	</div>
</div>
<div class="row bottom-row" ng-show="item.price || item.secondary_price">
	<div class="col col-xs-12 right-col">
		<span ng-show="item.contract_type.id != 2 && item.price">قیمت: </span>
		<span ng-show="item.contract_type.id == 2 && item.price">رهن: </span>
		<span ng-show="item.price" class="item-price" ng-bind="item.price + ' تومان'"></span>
		<span ng-show="item.price && item.secondary_price">-</span>
		<span ng-show="item.contract_type.id == 2 && item.secondary_price">اجاره: </span>
		<span ng-show="item.secondary_price" class="item-price" ng-bind="item.secondary_price + ' تومان'"></span>
	</div>
</div>


