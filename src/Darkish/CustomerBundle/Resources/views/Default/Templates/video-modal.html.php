<div class="video-modal">
  	<video id="modal-video-player" controls="" name="media" width="300">
  		<source ng-src="{{videos[index].absolute_path}}" type="video/mp4">
	</video>
  	<button class="btn btn-default previous-btn" ng-disabled="index <= 0" ng-click="previous()">
    	<div class="dk icon-arrow-right"></div>
  	</button>
  	<button class="btn btn-default next-btn" ng-disabled="index >= (videos.length -1)" ng-click="next()">
    	<div class="dk icon-arrow-left"></div>
  	</button>
</div>