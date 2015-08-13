<div class="row top-row">
	<div class="col col-xs-8 right-col">
		<span class="item-brand" ng-bind="item.automobile_brand.value + ((item.automobile_type)?'-':'') + item.automobile_type.value"></span>
		<span class="record-title" ng-bind="user.record.title"></span>
	</div>
	<div class="col col-xs-4 left-col">
		<span ng-show="item.code" class="item-code">کد {{item.code}}</span>
	</div>
	
</div>
<div class="row middle-row">

	<div class="col col-xs-8 right-col">
		<span class="item-description" ng-bind="item.description">
		</span>
		<span class="item-tip" ng-bind="item.tip">
		</span>
	</div>

	<div class="col col-xs-4 left-col">
		<div ng-init="imageUrl = item.photos[0].icon_absolute_path ? item.photos[0].icon_absolute_path : null" 
			class="image-wrapper automobile-image"
			ng-style="(imageUrl) ? {'background-image': 'url('+imageUrl+')'} : null">
		</div>
		<div class="edit-buttons" ng-show="editmode">
			<button class="btn btn-danger remove-button" ng-click="deleteItem(item); $event.stopPropagation();"><div class="dk icon-trash"></div></button>
			<button ng-show="item.status" class="btn btn-warning disable-button" ng-click="disableItem(item); $event.stopPropagation();"><div class="dk icon-block"></div></button>
			<button ng-hide="item.status" class="btn btn-info enable-button" ng-click="enableItem(item); $event.stopPropagation();" ><div class="dk icon-verify-small"></button>
		</div>
	</div>





</div>

<div class="row bottom-row" ng-show="item.price || item.created_year || item.automobile_color">
	<div class="col col-xs-8 right-col">
		<span ng-show="item.price" class="item-price" ng-bind="item.price + ' تومان'"></span>
	</div>
	<div class="col col-xs-4 left-col">
		<span class="item-created-year" ng-bind="item.created_year"></span>-
		<span class="item-created-year" ng-bind="item.automobile_color.value"></span>
	</div>
</div>


