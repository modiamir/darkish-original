<h2>لیست اپراتورها <a ui-sref="add" class="btn btn-default btn-xs">ایجاد جدید</a></h2>
<hr/>

<table st-pipe="refresh" st-table="displayedOperators" st-safe-src="operators"  class="operators-table table table-striped">
	<thead>
	<tr>
		<th st-sort="id" >شناسه</th>
		<th st-sort="email" >پست الکترونیگ</th>
		<th st-sort="username" >نام کاربری</th>
		<th>نقش ها</th>
                <th>فعال</th>
                <th>عملیات</th>
	</tr>
        
	</thead>
	<tbody>
	<tr st-select-row="operator" st-select-mode="multiple" ng-repeat="operator in displayedOperators">
		<td>{{operator.id}}</td>
		<td>{{operator.email}}</td>
		<td>{{operator.username}}</td>
                <td>
                    <ul>
                        <li ng-repeat="role in operator.roles">
                            {{role.name}}
                        </li>
                    </ul>
                </td>
		<td>{{(operator.is_active)?'بله' : 'خیر'}}</td>
                <td>
                    <button type="button" ng-click="delete(operator, $index); $event.stopPropagation();" class="btn btn-sm btn-danger">
                        <i class="glyphicon glyphicon-remove-circle">
                        </i>
                    </button>
                    <button type="button" ng-click="$event.stopPropagation();" ui-sref="edit({ id: operator.id })" class="btn btn-sm btn-info">
                        <i class="glyphicon glyphicon-edit">
                        </i>
                    </button>
                </td>
	</tr>
	</tbody>
        <thead>
	<tr>
		<th>شناسه</th>
		<th>پست الکترونیگ</th>
		<th>نام کاربری</th>
		<th>نقش ها</th>
                <th>فعال</th>
                <th>عملیات</th>
	</tr>
	</thead>
        <tfoot>
                <tr>
                        <td colspan="5" class="text-center">
                                <div st-pagination="" st-items-by-page="itemsByPage"></div>
                        </td>
                </tr>
        </tfoot>
</table>