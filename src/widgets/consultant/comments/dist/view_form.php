<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $api \Site\Consultant\ConsultantCommentsAPI */

$api = $this->argument();

$enableEdit = $this->param('enableEdit');

Widget('info::enable');

RequireLib('angular-readmore');

Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));

?>
<div class="panel panel-default widget" ng-controller="consultantCommentsViewController">
    <div class="panel-heading">
        <i class="fa fa-comments fa-fw"></i> Comments
<?php if ($enableEdit) {?>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default btn-xs" ng-click="add()">
                <i class="fa fa-plus"></i> Add
            </button>
        </div>
        <div class="clearfix"></div>
<?php }?>
    </div>
    <div class="panel-body">
        <ul class="chat">
            <li class="left clearfix" ng-repeat="item in list | limitTo:pagination.limit:(pagination.page * pagination.limit)">
                <span class="chat-img pull-left">
                  <a href="" ng-click="displayConsultantInfo(item)">
                    <img ng-src="{{item.consultant.thumbnail.url}}" width="50" alt="User Avatar" class="img-circle">
                  </a>
                </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <strong class="primary-font">{{item.consultant.name}}</strong>
                        
                        <button type="button" class="btn btn-default btn-xs" ng-click="edit(item)" title="Edit comment"><i class="glyphicon glyphicon-edit" style="margin: 0px"></i></button>
                        <button type="button" class="btn btn-default btn-xs" ng-click="drop(item)" title="Delete comment"><i class="glyphicon glyphicon-trash" style="margin: 0px"></i></button>
                        
                        <small class="pull-right text-muted">
                            <i class="fa fa-clock-o fa-fw"></i> {{item.date}} 
                        </small>
                    </div>
                    <p ng-read-more ng-rm-text="{{item.text}}" ng-rm-limit="100"></p>
                </div>
            </li>
        </ul>
    </div>
    <div class="panel-footer" ng-if="pagination.total.pages > 1">
        <div class="text-right">
          <div class="btn-group btn-group-xs">
            <button class="btn btn-link" title="{{pagination.page <= 0 ? 'Там ничего нет. Совсем ничего.' : ''}}" ng-disabled="pagination.page <= 0" ng-click="pagination.page = pagination.page-1">&lt;&lt; Previous</button>
            <button class="btn btn-link" title="{{pagination.page + 1 >= pagination.total.pages ? 'И тут ничего нет. Ни капельки.' : ''}}" ng-disabled="pagination.page + 1 >= pagination.total.pages" ng-click="pagination.page = pagination.page + 1">Next &gt;&gt;</button>
          </div>
        </div>
    </div>
</div>