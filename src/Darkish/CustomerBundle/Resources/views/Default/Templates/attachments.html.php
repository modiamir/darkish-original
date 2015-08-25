
<div class="row attachement-page page">
	

	<div class="col col-xs-12 details">
		
		<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
			<button ng-click="saveAttachment()" class="details-header-button btn btn-sm btn-primary">
				<span class="">ذخیره</span>
				<div class="dk icon-arrow-left"></div>
			</button>
			

		</div>

		<div class="store-create-product details-inner well">
			<div class="btn-group btn-group-justified tabs" role="group" aria-label="Justified button group">
		      	<a ng-class="{'active': currentTab == 'image'}" ng-click="selectTab('image')"  class="btn btn-default" role="button">تصویر</a>
		      	<a ng-class="{'active': currentTab == 'video'}" ng-click="selectTab('video')"  class="btn btn-default" role="button">ویدئو</a>
		    </div>
		    <div class="input-group upload-input-group">
		      	<input ng-disabled="disableUpload()" type="text" ng-model="fileTitle" class="form-control" placeholder="عنوان فایل" aria-describedby="sizing-addon1">
		      	<label ng-disabled="disableUpload()" class="input-group-addon btn-default btn" id="sizing-addon1">بارگذاری
		      		<input type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
		      	</label>
		    </div>
			<div class="progress" style="">
	            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
	        </div>
	        <div class="remaining-uploads">
	        	تعداد فایل قابل بارگذاری: {{remaining()}} از {{uploadable()}}
	        </div>
			<div class="files-list row" ng-class="currentTab+'-list'">
				<div class="col col-xs-6 col-sm-4"  ng-repeat="media in currentMedias()">
					<div class="file-item" ng-include="getMediaTemplate()"  >{{media.id}}</div>
				</div>
			</div>

		</div>
	
	</div>


</div>

<script type="text/ng-template" id="image-list-item.html">
	<div class="image-item-list media-item-list">
		<img ng-click="openPhotoModal(recordData.images, $index)" ng-src="{{media.icon_absolute_path}}" width="100" />
		<div class="file-name-btns">
			<span class="file-name" ng-bind="(media.title)? media.title : media.file_name"></span>
			<button class="btn btn-danger btn-sm" ng-click="removeFromList(media, $index)">حذف</button>
		</div>
	</div>
</script>

<script type="text/ng-template" id="video-list-item.html">
	<div class="video-item-list media-item-list">
		<div ng-click="openVideoModal(recordData.videos, $index)" class="dk icon-video"></div>
		<div class="file-name-btns">
			<span class="file-name" ng-bind="(media.title)? media.title : media.file_name"></span>
			<button class="btn btn-danger btn-sm" ng-click="removeFromList(media, $index)">حذف</button>

		</div>
	</div>
</script>