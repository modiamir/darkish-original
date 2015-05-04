<div class="store-edit">
	<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
		<button ng-disabled="state.current.name == 'store'" class="return-button" ui-sref="store" href="#/store" aria-disabled="false">
			<div class="dk icon-arrow-right"></div>
			<span class="hidden-xs">بازگشت</span>
		</button>
		{{product.title}}
		<button  ui-sref="store.editproduct({pid:product.id})" class="details-header-button btn btn-sm btn-primary" href="#/store/product/1/edit">
			<div class="dk icon-edit"></div>
			<span class="hidden-xs">ویرایش</span>			
		</button>
	</div>
	<div class="store-create-product details-inner well">
		<form name="productcreate">
			<div class="row">
				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-code">کد آیتم</label>
				  <input ng-disabled="true" class="form-control" id="product-code" type="number"
				  		 minlength="6" maxlength="6" placeholder="شماره آیتم" ng-model="product.code"
				  		 required>
				</div>

				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-group">گروه محصول</label>
				  <select ng-disabled="true" required class="form-control" id="product-group" ng-model="product.group"
				  			ng-options="group.name for group in storeData.market_groups">
		            
		          </select>
				</div>
			    
			</div>
			<div class="row">
				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-title">عنوان محصول</label>
				  <input ng-disabled="true" class="form-control" id="product-title" type="text"
				  		 placeholder="عنوان محصول" ng-model="product.title"
				  		 maxlength="50" required>
				</div>
				<div class="col col-sm-6 form-group">
				  <label class="control-label" for="product-special-text">متن ویژه</label>
				  <textarea disabled="true" rows="5" class="form-control" id="product-special-text" 
				  		 placeholder="متن ویژه" ng-model="product.special_text"
				  		 maxlength="255"></textarea>
				</div>
			    
			</div>
			<div class="row">
			    <div class="col col-sm-6 form-group price-group">
			      <label class="control-label" for="product-price">قیمت</label>
			      <div class="input-group">
				      <input ng-disabled="true" class="form-control" id="product-price" type="number"
				      		 placeholder="قیمت" ng-model="product.price"
				      		 maxlength="12" required>
		      		  <span class="input-group-addon">تومان</span>
	      		  </div>
	      		  

			    </div>


			    <div class="col col-sm-6 form-group">
			      	<label class="control-label" for="product-discount-percent">قیمت با تخفیف</label>
			      	<div class="input-group">
			      		<input ng-disabled="true" class="form-control" id="product-discount-percent" type="number"
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
				            		<input ng-disabled="true" type="radio"
			            				value="1" 
			            				ng-model="product.availability">
		            				موجود
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input ng-disabled="true" type="radio"
			            				value="0" ng-checked="true"
			            				ng-model="product.availability">
		            				ناموجود
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input ng-disabled="true" type="radio"
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
				            		<input ng-disabled="true" type="radio"
			            				value="0" ng-checked="true"
			            				ng-model="product.special_tag">
		            				-
				          		</label>
				      		</div>
				        	<div class="">
				        		<label>
				            		<input ng-disabled="true" type="radio"
			            				value="1" 
			            				ng-model="product.special_tag">
		            				جدید
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input ng-disabled="true" type="radio"
			            				value="2"
			            				ng-model="product.special_tag">
		            				پیشنهاد ویژه
				          		</label>
				        	</div>
				        	<div class="">
				          		<label>
				            		<input ng-disabled="true" type="radio"
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
			    	    <textarea ng-disabled="true" class="form-control" rows="7" id="product-description"
			    	    		  ng-model="product.description" maxlength="1000"></textarea>
				    </div>
				</div>
			</div>
			<hr ng-show="product.photos"/>
			<div class="row" ng-show="product.photos">
				<div class="col col-xs-4" ng-repeat="photo in product.photos">
					<img ng-src="{{photo.icon_absolute_path}}" />
				</div>
			</div>			
		</form>

	</div>
</div>