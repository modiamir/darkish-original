
<div ng-show="!user" class="loading">
	loading
</div>
<div ng-show="user" class="span3 well">
    <center>
    <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><img ng-src="{{user.photo.icon_absolute_path}}" name="aboutme" width="140" height="140" class="img-circle"></a>
    <h2 ng-bind="user.username"></h2>
    <h3 ng-bind="user.full_name"></h3>
    <span><strong>دسترسی ها: </strong></span>
    <span ng-repeat="access in user.assistant_access" style="margin-left: 3px; margin-right: 3px;" class="label label-warning" ng-bind="access.name"></span>
	</center>
</div>			