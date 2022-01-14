app.component('widget-list-footer', {
  template: `
<div class="panel-footer">
  <div class="row">
    <div class="col-md-4">
      <div class="pull-left">
        Всего в списке: {{filteredList.length}}
      </div>
    </div>
    <div class="col-md-8">
      <form class="form-inline pull-right">
        <div class="form-group hidden-xs">
          <label>Показывать на странице </label>
          <select class="form-control input-sm" ng-model="pager.limit" ng-options="i for i in [5, 10, 25, 50, 999]" ng-change="pager.page=0"></select>
        </div>
        <div class="form-group form-group-sm">
          <label class="control-label hidden-xs">Страница</label>
          <button class="btn btn-default btn-sm" ng-disabled="pager.page <= 0" ng-click="pager.page = pager.page - 1">&lt;&lt;</button>
          <select class="form-control input-sm hidden-xs" ng-model="pager.page" ng-options="i + 1 for i in pager.pages"></select>
          <button class="btn btn-default btn-sm" ng-disabled="pager.page +1 >= pager.pages.length" ng-click="pager.page = pager.page + 1">&gt;&gt;</button>
        </div>
      </form>
    </div>
  </div>
</div>
`,
  props: []
})
