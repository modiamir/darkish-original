<div class="media" ng-class="{'pending': child.state == 3}">
  <div class="media-left">
    <img class="media-object" ng-src="{{child.owner.photo ? child.owner.photo.icon_absolute_path : ''}}" data-src="holder.js/64x64" alt="64x64" src="data:image/jpg;base64,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" data-holder-rendered="true">
  </div>
  <div class="media-body">
    <span class="comment-id" ng-bind="'#'+child.id "></span>
    <span class="comment-date" am-time-ago="child.created_at"></span>
    <span ng-show="child.unseen_by_customers" class="is-new">جدید</span>
    <span ng-show="child.state == 3" class="label label-danger">در انتظار تایید</span>
    <div class="comment-body" ng-bind="child.body"></div>
    <div class="operations">
  		<button ng-disabled="child.has_liked" type="button" ng-click="like(child)" class="btn btn-info btn-xs ng-binding">
  			<div class="dk icon-like dk-flip-horizontal"></div><span class="badge" ng-bind="child.like_count"></span>
  		</button>
  		<div class="dropdown">
        <button ng-disabled="child.claim_type" class="btn btn-warning btn-xs dropdown-toggle" type="button" id="claimtypedropdowm" data-toggle="dropdown" aria-expanded="true">
          شکایت
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="claimtypedropdowm">
          <li ng-repeat="claimType in claimTypes"><a ng-click="setClaim(child,claimType)">{{claimType.label}}</a></li>
        </ul>
      </div>
      <button ng-show="child.owner_type == 'client'" class="btn btn-info btn-xs" ng-click="openSendMessageModal(child)">ارسال پیام</button>

	  </div>
    
  </div>
</div>