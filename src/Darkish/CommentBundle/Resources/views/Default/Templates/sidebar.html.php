<div class="search-entity-box search-record-box" ng-show="stateParams.type == 'record'">
	<h3>
		جستجوی رکوردها
	</h3>
	<div class="search-record-by-number-box">
		<angucomplete-alt id="records"
		              placeholder="جستجوی رکوردها"
		              pause="400"
		              selected-object="selectEntityCallback"
		              remote-url="comment/ajax/get_entity_list/record/number/"
		              remote-url-data-field="results"
		              title-field="record_number,title"
		              description-field="sub_title"
		              minlength="1"
		              image-field="profilePic"
		              input-class="form-control form-control-small"/>
	</div>

	<div class="search-record-by-name-box">
		<angucomplete-alt id="records"
		              placeholder="جستجوی رکوردها"
		              pause="400"
		              selected-object="selectEntityCallback"
		              remote-url="comment/ajax/get_entity_list/record/name/"
		              remote-url-data-field="results"
		              title-field="record_number,title"
		              description-field="sub_title"
		              minlength="1"
		              image-field="profilePic"
		              input-class="form-control form-control-small"/>
	</div>
</div>

<div class="search-entity-box search-news-box" ng-show="stateParams.type == 'news'">
	<h3>
		جستجوی اخبار
	</h3>
	<div class="search-news-by-number-box">
		<angucomplete-alt id="news"
		              placeholder="جستجوی اخبار"
		              pause="400"
		              selected-object="selectEntityCallback"
		              remote-url="comment/ajax/get_entity_list/news/number/"
		              remote-url-data-field="results"
		              title-field="id,title"
		              description-field="sub_title"
		              minlength="1"
		              image-field="profilePic"
		              input-class="form-control form-control-small"/>
	</div>

	<div class="search-news-by-name-box">
		<angucomplete-alt id="news"
		              placeholder="جستجوی اخبار"
		              pause="400"
		              selected-object="selectEntityCallback"
		              remote-url="comment/ajax/get_entity_list/news/name/"
		              remote-url-data-field="results"
		              title-field="id,title"
		              description-field="sub_title"
		              minlength="1"
		              image-field="profilePic"
		              input-class="form-control form-control-small"/>
	</div>
</div>

<div class="search-entity-box search-safarsaz-box" ng-show="stateParams.type == 'safarsaz'">
	<h3>
		جستجوی اخبار
	</h3>
	<div class="search-safarsaz-by-number-box">
		search-safarsaz-by-number-box
	</div>

	<div class="search-safarsaz-by-name-box">
		search-safarsaz-by-name-box
	</div>
</div>