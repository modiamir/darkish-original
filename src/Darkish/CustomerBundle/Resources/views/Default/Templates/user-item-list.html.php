<div class="assistant-list-item">
	<div ng-init="imageUrl = user.photo.icon_absolute_path ? user.photo.icon_absolute_path : null" 
		class="image-wrapper" 
		ng-style="(imageUrl) ? {'background-image': 'url('+imageUrl+')'} : null">
	</div>
	<div class="list-details">
		<span class="username" ng-bind="user.username">
		</span>
		<span class="fullname" ng-bind="user.full_name">
		</span>
	</div>
</div>
