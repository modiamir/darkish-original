<div class="audio-modal">
  	<audio id="modal-audio-player" controls="" name="media" width="300">
  		<source ng-src="{{audios[index].absolute_path}}" type="audio/mp3">
	</audio>
  	<button class="btn btn-default previous-btn" ng-disabled="index <= 0" ng-click="previous()">
    	<div class="dk icon-arrow-right"></div>
  	</button>
  	<button class="btn btn-default next-btn" ng-disabled="index >= (audios.length -1)" ng-click="next()">
    	<div class="dk icon-arrow-left"></div>
  	</button>
</div>