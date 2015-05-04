<div class="store-create">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'store'" class="return-button" 
			ui-sref="store">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		آیتم جدید
		<button ng-disabled="productcreate.$invalid" ng-click="saveProduct()" class="details-header-button btn btn-sm btn-primary">
			<span class="hidden-xs">ذخیره</span>
			<div class="dk icon-arrow-left"></div>
		</button>
	</div>
	<div class="store-create-product details-inner well">
		<form name="productcreate">
			<div class="row">
				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-code">کد آیتم</label>
				  <input class="form-control" id="product-code" type="number"
				  		 minlength="1" maxlength="4" placeholder="شماره آیتم" ng-model="product.code"
				  		 required>
				</div>

				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-group">گروه محصول</label>
				  <select required class="form-control" id="product-group" ng-model="product.group"
				  			ng-options="group.name for group in storeData.market_groups">
		            
		          </select>
				</div>
			    
			</div>
			<div class="row">
				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-title">عنوان محصول</label>
				  <input class="form-control" id="product-title" type="text"
				  		 placeholder="عنوان محصول" ng-model="product.title"
				  		 maxlength="50" required>
				</div>
				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-special-text">متن ویژه</label>
				  <textarea rows="5" class="form-control" id="product-special-text" 
				  		 placeholder="متن ویژه" ng-model="product.special_text"
				  		 maxlength="255"></textarea>
				</div>
			    
			</div>
			<div class="row">
			    <div class="col col-sm-6 form-group price-group">
			      <label class="control-label" for="product-price">قیمت</label>
			      <div class="input-group">
				      <input class="form-control" id="product-price" type="number"
				      		 placeholder="قیمت" ng-model="product.price"
				      		 maxlength="12" required>
		      		  <span class="input-group-addon">تومان</span>
	      		  </div>
	      		  

			    </div>


			    <div class="col col-sm-6 form-group">
			      	<label class="control-label" for="product-discount-percent">قیمت با تخفیف</label>
			      	<div class="input-group">
			      		<input class="form-control" id="product-discount-percent" type="number"
			      			 placeholder="قیمت با تخفیف" ng-model="product.discounted_price"
			      			 maxlength="12">
		      			<span class="input-group-addon">تومان</span>
			      	</div>
			      
			    </div>
			    
			</div>

			<div class="row">
				<div class="col col-md-3">
					<div class="form-group">
				      	<label class="control-label">وضعیت</label>
				      	<div class="radio-box">
				        	<div class="">
				          		<label>
				            		<input type="radio"
			            				value="1" 
			            				ng-model="product.availability">
		            				موجود
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input type="radio"
			            				value="0" ng-checked="true"
			            				ng-model="product.availability">
		            				ناموجود
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input type="radio"
			            				value="2"
			            				ng-model="product.availability">
		            				به زودی
				          		</label>
				        	</div>
				      	</div>
				    </div>
				</div>
				<div class="col col-md-3">
					<div class="form-group">
				      	<label class="control-label">برچسب ویژه</label>
				      	<div class="radio-box">
				      		<div class="">
				      			<label>
				            		<input type="radio"
			            				value="0" ng-checked="true"
			            				ng-model="product.special_tag">
		            				-
				          		</label>
				      		</div>
				        	<div class="">
				        		<label>
				            		<input type="radio"
			            				value="1" 
			            				ng-model="product.special_tag">
		            				جدید
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input type="radio"
			            				value="2"
			            				ng-model="product.special_tag">
		            				پیشنهاد ویژه
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input type="radio"
			            				value="3"
			            				ng-model="product.special_tag">
		            				تخفیف
				          		</label>
				        	</div>
				      	</div>
				    </div>
				</div>
				<div class="col col-md-6">
					<div class="form-group">
				        <label for="product-description" class="control-label">توضیحات</label>
			    	    <textarea class="form-control" rows="7" id="product-description"
			    	    		  ng-model="product.description" maxlength="1000"></textarea>
				    </div>
				</div>
			</div>
			<hr ng-show="product.photos"/>
			<div class="row" ng-show="product.photos">
				<div class="col col-xs-4" ng-repeat="photo in product.photos">
					<img ng-src="{{photo.icon_absolute_path}}" />
					<button class="btn btn-danger btn-xs" ng-click="removePhoto($index)">حذف</button>
				</div>
			</div>
			<!-- <hr/>
			<div class="row">

	            <div class="col-md-12" style="margin-bottom: 40px">
	                <h2>بارگذاری تصاویر (فقط سه تصویر)</h2>
	                <p>تعداد تصاویر: {{ uploader.queue.length }}</p>

	                <table class="table">
	                    <thead>
	                        <tr>
	                            <th width="30%">نا‍م</th>
	                            <th width="20%" ng-show="uploader.isHTML5">اندازه</th>
	                            <th width="10%" ng-show="uploader.isHTML5"></th>
	                            <th width="10%">وضعیت</th>
	                            <th width="20%">عملیات</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr ng-repeat="item in uploader.queue">
	                            <td width="30%">
	                                <strong>{{ item.file.name }}</strong>
	                                <div ng-show="uploader.isHTML5" ng-thumb="{ file: item._file, height: 100 }"></div>
	                                
	                            </td>
	                            <td width="20%" ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
	                            <td width="10%" ng-show="uploader.isHTML5">
	                                <div class="progress" style="margin-bottom: 0;">
	                                    <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
	                                </div>
	                            </td>
	                            <td width="10%" class="text-center">
	                                <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
	                                <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
	                                <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
	                            </td>
	                            <td width="30%" nowrap>
	                                <button style="float: right;  margin-top: 3px; clear: both;" type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
	                                    <span class="glyphicon glyphicon-upload"></span> بارگذاری
	                                </button>
	                                <button style="float: right;  margin-top: 3px; clear: both;" type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
	                                    <span class="glyphicon glyphicon-ban-circle"></span> انصراف
	                                </button>
	                                <button style="float: right; margin-top: 3px; clear:both" type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
	                                    <span class="glyphicon glyphicon-trash"></span> حذف
	                                </button>
	                            </td>
	                        </tr>
	                    </tbody>
	                </table>

	                <div>
	                    <div>
	                        صف بارگذاری:
	                        <div class="progress" style="">
	                            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
	                        </div>
	                    </div>
	                    <label class="btn btn-info">
	                    	انتخاب فایل
	                    	<input type="file" ng-show="false" nv-file-select="" uploader="uploader" multiple  /><br/>
	                    </label>
	                    <button type="button" class="btn btn-success btn-s" ng-click="uploader.uploadAll()" ng-disabled="!uploader.getNotUploadedItems().length">
	                        <span class="glyphicon glyphicon-upload"></span> بارگذاری همه
	                    </button>
	                    <button type="button" class="btn btn-warning btn-s" ng-click="uploader.cancelAll()" ng-disabled="!uploader.isUploading">
	                        <span class="glyphicon glyphicon-ban-circle"></span> انصراف همه
	                    </button>
	                    <button type="button" class="btn btn-danger btn-s" ng-click="uploader.clearQueue()" ng-disabled="!uploader.queue.length">
	                        <span class="glyphicon glyphicon-trash"></span> حذف همه
	                    </button>
	                    
	                </div>

	            </div>

	        </div> -->

			
		</form>

	</div>
</div>