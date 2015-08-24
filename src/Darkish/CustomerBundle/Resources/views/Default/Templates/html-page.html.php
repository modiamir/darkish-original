
<div class="row html-page page">
	<div class="col col-xs-12 col-sm-5 col-md-4 col-lg-4 file-list master">
		<div class="well master-buttons" ng-class="{'fixed': isXSmall()}"> 
			<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
		      <a ng-class="{'active': currentTab == 'image'}" ng-click="selectTab('image')"  class="btn btn-default" role="button">تصویر</a>
		      <a ng-class="{'active': currentTab == 'video'}" ng-click="selectTab('video')"  class="btn btn-default" role="button">ویدئو</a>
		      <a ng-class="{'active': currentTab == 'audio'}" ng-click="selectTab('audio')"  class="btn btn-default" role="button">صدا</a>
		      <a ng-class="{'active': currentTab == 'doc'}"   ng-click="selectTab('doc')"    class="btn btn-default" role="button">دیگر</a>
		    </div>
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
		<div class="master-inner well" ng-class="{'scrollable': !isXSmall()}">
			
			<ul class="files-list" ng-class="currentTab+'-list'">
				<li class="file-item" ng-repeat="media in currentMedias()" ng-include="getMediaTemplate()"  >{{media.id}}</li>
			</ul>

		</div>
		
	</div>

	<div class="col col-xs-12 col-sm-7  col-md-8 col-lg-8 details">
		
		<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
			<button ng-show="bodyMode == 'edit'" ng-click="bodyMode = 'preview'" class="return-button btn btn-sm btn-primary" >
				<span class="">پیش نمایش</span>			
				<div class="dk icon-display"></div>
			</button>
			<button ng-show="bodyMode == 'preview'" ng-click="bodyMode = 'edit'" class="return-button btn btn-sm btn-primary" >
				<span class="">ویرایش</span>			
				<div class="dk icon-edit"></div>
			</button>
			{{product.title}}
			<button ng-click="saveHtml()" class="details-header-button btn btn-sm btn-primary">
				<span class="">ذخیره</span>
				<div class="dk icon-arrow-left"></div>
			</button>
			

		</div>
		<div class="store-create-product details-inner well">
			<div ng-show="bodyMode == 'edit'" class="editor-box">
				<textarea  ckeditor="bodyEditorOptions" ng-model="recordData.body"></textarea>
			</div>
			<div ng-show="bodyMode == 'preview'" class="body-preview" bind-html-compile="getTrustBody()"></div>

		</div>
	
	</div>


</div>

<script type="text/ng-template" id="image-list-item.html">
	<div class="image-item-list media-item-list">
		<img ng-click="openPhotoModal(recordData.body_images, $index)" ng-src="{{media.icon_absolute_path}}" width="100" />
		<div class="file-name-btns">
			<span class="file-name" ng-bind="(media.title)? media.title : media.file_name"></span>
			<button class="btn btn-danger btn-sm" ng-click="removeFromList(media, $index)">حذف</button>
			<button class="btn btn-info btn-sm" ng-click="insertIntoBody(media)">درج</button>
		</div>
	</div>
</script>

<script type="text/ng-template" id="video-list-item.html">
	<div class="video-item-list media-item-list">
		<div ng-click="openVideoModal(recordData.body_videos, $index)" class="dk icon-video"></div>
		<div class="file-name-btns">
			<span class="file-name" ng-bind="(media.title)? media.title : media.file_name"></span>
			<button class="btn btn-danger btn-sm" ng-click="removeFromList(media, $index)">حذف</button>
			<button class="btn btn-info btn-sm" ng-click="insertIntoBody(media)">درج</button>
		</div>
	</div>
</script>

<script type="text/ng-template" id="audio-list-item.html">
	<div class="audio-item-list media-item-list">
		<div ng-click="openAudioModal(recordData.body_audios, $index)" class="dk icon-audio"></div>
		<div class="file-name-btns">
			<span class="file-name" ng-bind="(media.title)? media.title : media.file_name"></span>
			<button class="btn btn-danger btn-sm" ng-click="removeFromList(media, $index)">حذف</button>
			<button class="btn btn-info btn-sm" ng-click="insertIntoBody(media)">درج</button>
		</div>
	</div>
</script>

<script type="text/ng-template" id="doc-list-item.html">
	<div class="doc-item-list media-item-list">
		<div class="dk icon-edit"></div>
		<div class="file-name-btns">
			<span class="file-name" ng-bind="(media.title)? media.title : media.file_name"></span>
			<button class="btn btn-danger btn-sm" ng-click="removeFromList(media, $index)">حذف</button>
			<button class="btn btn-info btn-sm" ng-click="insertIntoBody(media)">درج</button>
		</div>
	</div>
</script>
