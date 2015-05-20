<div class="comment-photo-modal">
  <img class="photo-in-modal" ng-src="{{photos[index].web_absolute_path}}" />
  <button class="btn btn-default previous-btn" ng-disabled="index <= 0" ng-click="index = index-1">
    <div class="dk icon-arrow-right"></div>
  </button>
  <button class="btn btn-default next-btn" ng-disabled="index >= (photos.length -1)" ng-click="index = index+1">
    <div class="dk icon-arrow-left"></div>
  </button>
</div>