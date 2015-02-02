<div class="btn-group">
    <button ui-sref="add" class="btn btn-info">جدید</button>
</div>
<h2>لیست اپراتورها </h2>
<hr/>

<table st-pipe="refresh" st-table="displayedOperators" st-safe-src="operators"  class="operators-table table table-striped">
	<thead>
	<tr>
		<th st-sort="id" >شناسه</th>
		<th st-sort="email" >پست الکترونیک</th>
		<th st-sort="username" >نام کاربری</th>
		<th>نقش ها</th>
                <th>سازنده</th>
                <th>فعال</th>
                <th>عملیات</th>
	</tr>
        
	</thead>
	<tbody>
            <tr ng-dblclick="editOperator(operator)" st-select-row="operator" st-select-mode="single" ng-repeat="operator in displayedOperators">
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
                <td>{{operator.creator.username}}</td>
                <td>
                    <span ng-click="toggleIsActive(operator);$event.stopPropagation()"><switch id="enabled" name="enabled" ng-model="operator.is_active" class="is-active-switch"></switch></span>
                </td>
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
		<th>پست الکترونیک</th>
		<th>نام کاربری</th>
		<th>نقش ها</th>
                <th>سازنده</th>
                <th>فعال</th>
                <th>عملیات</th>
	</tr>
	</thead>
        <tfoot>
                <tr>
                        <td colspan="7" class="text-center">
                                <div st-pagination="" st-items-by-page="itemsByPage"></div>
                        </td>
                </tr>
        </tfoot>
</table>